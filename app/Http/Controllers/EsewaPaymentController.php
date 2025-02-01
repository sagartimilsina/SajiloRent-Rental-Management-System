<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment_Records;
use App\Models\Payments;
use App\Models\Propeerty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class EsewaPaymentController extends Controller
{
    // Switch between production and testing environments
    protected $isTesting;

    public function __construct()
    {
        // Set testing or production environment
        $this->isTesting = env('ESEWA_TESTING', true); // You can set ESEWA_TESTING in .env file
    }

    public function success(Request $request)
    {
        // Get the data from the URL (if using GET for testing)
        $encodedData = $request->query('data'); // Get the data from query string
        $decodedData = base64_decode($encodedData); // Decode the base64 string

        // Parse the JSON response
        $paymentData = json_decode($decodedData, true); // Decode JSON into an array
        // Retrieve cart items from session
        $cartItems = session('cartItems', []);

        if (empty($cartItems)) {
            return redirect()->route('payment.failure')->with('error', 'No cart items found in session.');
        }

        // Extract necessary data from the payment response
        $transactionCode = $paymentData['transaction_code'] ?? null;
        $status = $paymentData['status'] ?? 'PENDING';
        $totalAmount = $paymentData['total_amount'] ?? null;
        $transactionUuid = $paymentData['transaction_uuid'] ?? null;
        $productCode = $paymentData['product_code'] ?? null;
        $signature = $paymentData['signature'] ?? null;

        // Save the payment data to the database

        foreach ($cartItems as $cartItem) {
            $payment = new Payments();
            $payment->user_id = auth()->id(); // Assuming the user is authenticated
            $payment->property_id = $cartItem['property_id'];
            $payment->property_quantity = $cartItem['property_quantity'];
            $payment->payment_method = 'ESEWA';
            $payment->status = $status;
            $payment->transaction_code = $transactionCode;
            $payment->transaction_uuid = $transactionUuid;
            $payment->signature = $signature;
            $payment->total_amount = $totalAmount;
            $payment->payment_date = now(); // Set the payment date to the current timestamp
            $payment->save();
        }
        $property = Propeerty::findOrFail($cartItem['property_id']);
        $property->property_quantity = $property->property_quantity - $cartItem['property_quantity'];
        $property->save();

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('property_id', $cartItem['property_id'])
            ->delete();

        // Clear the cart items from the session after saving
        session()->forget('cartItems');

        // Redirect to the success page
        return redirect()->route('payment.success', ['transactionUuid' => $transactionUuid])->with('success', 'Payment successful.');
    }

    public function payment_success(Request $request)
    {
        $transactionUuid = $request->input('transactionUuid');
        // Prepare data for the invoice
        $invoiceData = Payments::where('transaction_uuid', $transactionUuid)
            ->with('property:id,property_name,property_sell_price', 'user:id,name')
            ->get();

        if ($invoiceData->isEmpty()) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        $cartItems = [];

        foreach ($invoiceData as $payment) {
            $cartItems[] = [
                'property_name'  => $payment->property->property_name,
                'property_quantity' => $payment->property_quantity,
                'property_price' => $payment->property->property_sell_price,
            ];
        }

        return view('frontend.invoice-bill.invoice', [
            'transactionUuid' => $transactionUuid,
            'transactionCode' => $invoiceData[0]->transaction_code,
            'paymentDate'     => $invoiceData[0]->payment_date,
            'paymentMethod'   => $invoiceData[0]->payment_method,
            'status'          => $invoiceData[0]->status,
            'cartItems'       => $cartItems,
            'totalAmount'     => $invoiceData[0]->total_amount,

        ])->with('success', 'Your payment has been processed successfully.');

        // } catch (\Exception $e) {
        //     // Log the error and redirect to the failure page
        //     Log::error('Payment save failed: ' . $e->getMessage());
        //     return redirect()->back()->with('error', 'Payment processing failed.');
        // }
    }

    public function payment_failure(Request $request)
    {
        return view('esewa.failure');
    }
    public function failure(Request $request)
    {
        $encodedData = $request->query('data'); // Get the data from query string
        $decodedData = base64_decode($encodedData); // Decode the base64 string

        // Parse the JSON response
        $paymentData = json_decode($decodedData, true); // Decode JSON into an array
        return $paymentData;
        return view('esewa.failure');
    }

    public function cancel(Request $request)
    {
        return view('esewa.cancel');
    }



    public function esewaPayment(Request $request)
    {
        // Validate request data
        $validatedData = Validator::make($request->all(), [
            'amount' => 'required',
            'tax_amount' => 'required',
            'total_amount' => 'required',
            'product_code' => 'required|string',
            'cartItems' => 'required|array|min:1',
            'cartItems.*.property_id' => 'required|integer|exists:propeerties,id',
            'cartItems.*.property_quantity' => 'required|integer|min:1',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->with('error', 'Validation failed: ' . implode(', ', $validatedData->errors()->all()));
        }

        // Store cart items in session
        $cartItems = $request->input('cartItems');
        session(['cartItems' => $cartItems]);


        // Generate the signature and prepare form data for eSewa
        $amount = $request->input('amount');
        $tax = $request->input('tax_amount');
        $totalAmount = $request->input('total_amount');
        $productCode = 'EPAYTEST';
        $transaction_uuid = $this->transaction_uuid();
        $product_delivery_charge = 0;
        $product_service_charge = 0;

        $signature = $this->generateSignature($totalAmount, $transaction_uuid, $productCode);

        $formData = [
            'amount' => $amount,
            'tax_amount' => $tax,
            'total_amount' => $totalAmount,
            'transaction_uuid' => $transaction_uuid,
            'product_code' => $productCode,
            'product_service_charge' => $product_service_charge,
            'product_delivery_charge' => $product_delivery_charge,
            'success_url' => route('esewa.success'),
            'failure_url' => route('esewa.failure'),
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'signature' => $signature,
        ];

        $isTesting = env('ESEWA_TESTING_MODE', true);

        // Return the form to be submitted automatically to eSewa
        return view('frontend.esewa.payment_form', compact('formData', 'isTesting'));
    }

    private function generateSignature($totalAmount, $transactionUuid, $productCode)
    {

        // eSewa SecretKey (test or production)
        $secretKey = $this->getSecretKey();

        // Concatenate required fields (in correct order)
        $data = 'total_amount=' . $totalAmount . ',transaction_uuid=' . $transactionUuid . ',product_code=' . $productCode;

        // Generate HMAC SHA256 hash with the SecretKey
        $hash = hash_hmac('sha256', $data, $secretKey, true);


        // Base64 encode the hash to generate the signature
        return base64_encode($hash);
    }

    private function transaction_uuid()
    {
        // Combine timestamp, random string, and user ID for unique transaction UUID
        $timestamp = time();
        $randomString = strtoupper(bin2hex(random_bytes(5))); // Random 10-character string
        $productId =
            $userId = auth()->check() ? auth()->user()->id : 'guest'; // User ID or 'guest'

        return "{$timestamp}-{$userId}-{$randomString}";
    }

    private function validateSignature($paymentData)
    {
        // eSewa SecretKey (test or production)
        $secretKey = $this->getSecretKey();

        // Concatenate required fields (in correct order)
        $data = 'total_amount=' . $paymentData['total_amount'] . ',transaction_uuid=' . $paymentData['transaction_uuid'] . ',product_code=' . $paymentData['product_code'];


        // Generate HMAC SHA256 hash with the SecretKey
        $hash = hash_hmac('sha256', $data, $secretKey, true);

        // Base64 encode the hash to generate the signature
        $signature = base64_encode($hash);
        dd($signature);

        // Compare the generated signature with the provided signature
        return $signature === $paymentData['signature'];
    }

    public function checkTransactionStatus(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'product_code' => 'required',
            'transaction_uuid' => 'required',
            'total_amount' => 'required',
        ]);

        // Extract validated data
        $productCode = $validatedData['product_code'];
        $transactionUuid = $validatedData['transaction_uuid'];
        $totalAmount = $validatedData['total_amount'];

        // Make API call to eSewa to check transaction status
        $response = Http::get($this->getApiUrl() . '/api/epay/transaction/status/', [
            'product_code' => $productCode,
            'transaction_uuid' => $transactionUuid,
            'total_amount' => $totalAmount,
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            $transactionStatus = $response->json();

            // Verify the signature in the response
            if ($this->validateSignature($transactionStatus)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $transactionStatus,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid signature in response',
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch transaction status',
            ], 400);
        }
    }

    // Get the appropriate eSewa secret key based on environment
    private function getSecretKey()
    {
        return $this->isTesting ? env('ESEWA_SECRET_KEY_TEST', '8gBm/:&EnhH.1/q') : env('ESEWA_SECRET_KEY_PROD');
    }

    // Get the appropriate eSewa API URL based on environment
    private function getApiUrl()
    {
        return $this->isTesting ? 'https://rc.esewa.com.np' : 'https://epay.esewa.com.np';
    }
}
