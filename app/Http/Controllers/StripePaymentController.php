<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Payments;
use App\Models\Property;
use App\Models\Propeerty;
use Stripe\PaymentIntent;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StripePaymentController extends Controller
{
    public function processPayment(Request $request)
    {

        $request->validate([
            'payment_method_id' => 'required',
            'total_amount' => 'required|numeric',
            'cardholder_name' => 'required|string',
            'currency' => 'required|string',
            'cartItems' => 'required|array',
        ]);

        $transactionUuid = Str::uuid()->toString();
        $amount = $request->input('total_amount');
        $currency = strtolower($request->input('currency'));
        $cartItems = $request->input('cartItems');

        session(['cartItems' => $cartItems]);


        $amountInCents = ($currency === 'npr')
            ? round($this->convertCurrency($amount, 'NPR', 'USD') * 100)
            : round($amount * 100);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => $currency === 'npr' ? 'usd' : $currency,
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success.stripe'),
            ]);



            if ($paymentIntent->status === 'succeeded') {
                $transaction_code = $paymentIntent->id;
                return $this->paymentSuccess($transactionUuid, $amount, $transaction_code);
            } else {
                return $this->paymentFailure("Payment failed. Status: " . $paymentIntent->status);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return $this->paymentFailure($e->getMessage());
        }
    }

    public function paymentSuccess($transactionUuid, $amount, $transaction_code)
    {
        $cartItems = session('cartItems', []);

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'No cart items found.');
        }
        foreach ($cartItems as $cartItem) {
            Payments::create([
                'user_id' => Auth::id(),
                'property_id' => $cartItem['property_id'],
                'property_quantity' => $cartItem['property_quantity'],
                'payment_method' => 'STRIPE',
                'status' => 'COMPLETE',
                'transaction_code' => $transaction_code,
                'transaction_uuid' => $transactionUuid,
                'total_amount' => $amount,
                'payment_date' => Carbon::now(),
            ]);

            $property = Propeerty::find($cartItem['property_id']);
            if ($property) {
                $property->property_quantity -= $cartItem['property_quantity'];  // Decrease available quantity
                $property->property_booked_quantity += $cartItem['property_quantity'];  // Increase booked quantity
                $property->save();
            }


            Cart::where('user_id', Auth::id())->where('property_id', $cartItem['property_id'])->delete();
        }

        session()->forget('cartItems');
        return redirect()->route('payment.invoice.stripe', ['transaction_uuid' => $transactionUuid])->with('success', 'Payment successful.');
    }


    private function convertCurrency($amount, $fromCurrency, $toCurrency)
    {
        $apiKey = config('services.exchange_rate_api.key');
        $apiUrl = "https://v6.exchangerate-api.com/v6/{$apiKey}/pair/{$fromCurrency}/{$toCurrency}/{$amount}";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            return $response->json()['conversion_result'] ?? 0;
        }

        return 0;
    }

    public function paymentInvoice(Request $request, $transaction_uuid)
    {

        try {
            // Prepare data for the invoice
            $invoiceData = Payments::where('transaction_uuid', $transaction_uuid)
                ->with('property:id,property_name,property_sell_price', 'user:id,name')
                ->get();
            $cartItems = [];

            foreach ($invoiceData as $payment) {
                $cartItems[] = [
                    'property_name'  => $payment->property->property_name,
                    'property_quantity' => $payment->property_quantity,
                    'property_price' => $payment->property->property_sell_price,
                ];
            }
            return view('frontend.payments.invoice-bill.invoice', [
                'transactionUuid' => $transaction_uuid,
                'transactionCode' => $invoiceData[0]->transaction_code,
                'paymentDate'     => $invoiceData[0]->payment_date,
                'paymentMethod'   => $invoiceData[0]->payment_method,
                'status'          => $invoiceData[0]->status,
                'cartItems'       => $cartItems,
                'totalAmount'     => $invoiceData[0]->total_amount,

            ])->with('success', 'Your payment has been processed successfully.');
        } catch (\Exception $e) {
            // Log the error and redirect to the failure page
            Log::error('Payment save failed: ' . $e->getMessage());
            return redirect()->route('payment.failure')->with('error', 'Payment processing failed.');
        }
    }

    public function paymentFailure()
    {
        return view('frontend.payments.failure')->with('error', 'Payment failed. Please try again.');
    }
}
