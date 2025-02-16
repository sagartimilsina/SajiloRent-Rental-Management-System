<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use GuzzleHttp\Client;
use App\Models\Payments;
use App\Models\Propeerty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\RequestException;

class KhaltiPaymentController extends Controller
{
    protected $client;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();

        $mode = config('services.khalti.mode', 'test');

        // Set the correct base URL based on mode
        $this->baseUrl = $mode === 'live'
            ? 'https://khalti.com/api/v2/'
            : 'https://a.khalti.com/api/v2/';

        $this->secretKey = $mode === 'live'
            ? config('services.khalti.live_secret_key')
            : config('services.khalti.test_secret_key');
    }

    public function initiatePayment(Request $request)
    {

        try {
            // Extract data from the request
            $cartItems = $request->input('cartItems');
            $user_id = $request->input('user_id');
            $amount = $request->input('amount');
            $tax_amount = $request->input('tax_amount');
            $total_amount = $request->input('total_amount');
            $purchase_order_name = $request->input('purchase_order_name');
            $customer_info = $request->input('customer_info');
            $amount_breakdown = $request->input('amount_breakdown');
            $product_details = $request->input('product_details');

            // Ensure phone is not null in customer_info
            if (empty($customer_info['phone'])) {
                $customer_info['phone'] = '9800000000'; // Provide a default phone number if null
            }

            // Convert amount_breakdown amounts to integers
            foreach ($amount_breakdown as &$breakdown) {
                $breakdown['amount'] = (int)($breakdown['amount'] * 100); // Convert to Paisa
            }

            // Prepare product_details with required fields
            // Prepare product_details with required fields
            $product_details = array_map(function ($item) {
                $property = \App\Models\Propeerty::find($item['property_id']); // Fetch the related property

                return [
                    'identity' => $item['property_id'],
                    'name' => $property ? $property->property_name : 'Unknown Property', // Fetch property name through relationship
                    'quantity' => (int) $item['property_quantity'],
                    'unit_price' => isset($item['unit_price']) ? (int) ($item['unit_price'] * 100) : 0,
                    'total_price' => isset($item['unit_price']) ? (int) ($item['property_quantity'] * $item['unit_price'] * 100) : 0,
                ];
            }, $cartItems);



            // Prepare payment data for Khalti
            $data = [
                'return_url' => route('khalti.verify'), // URL to redirect after payment
                'website_url' => config('app.url'), // Your website URL
                'amount' => (int)($total_amount * 100), // Convert to Paisa
                'purchase_order_id' => $this->purchaseOrderID($cartItems), // Generate unique order ID
                'purchase_order_name' => $purchase_order_name, // Order name
                'customer_info' => $customer_info, // Customer information
                'amount_breakdown' => $amount_breakdown, // Breakdown of the amount
                'product_details' => $product_details, // Details of the products
                'merchant_extra' => 'Property Purchase', // Additional merchant info
            ];

            // Make API request to Khalti
            $response = $this->client->post($this->baseUrl . 'epayment/initiate/', [
                'headers' => [
                    'Authorization' => 'Key ' . $this->secretKey,
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            $responseData = json_decode($response->getBody(), true);

            // Redirect to Khalti payment page if successful
            if (isset($responseData['payment_url'])) {
                return redirect($responseData['payment_url']);
            }

            // Handle failure
            return back()->with('error', 'Unable to initiate payment. Please try again.');
        } catch (RequestException $e) {
            Log::error('Khalti Payment Initiation Error: ' . $e->getMessage());

            // Log detailed error response if available
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody(), true);
                Log::error('Khalti Error Response: ', $errorResponse);
            }

            return back()->with('error', 'Payment initiation failed. Please try again later.');
        }
    }


    public function verifyPayment(Request $request)
    {
        try {
            if (!$request->has('pidx')) {
                return redirect()->route('payment.failed')
                    ->with('error', 'Payment verification failed: Missing payment ID');
            }

            $response = $this->client->post($this->baseUrl . 'epayment/lookup/', [
                'headers' => [
                    'Authorization' => 'Key ' . $this->secretKey,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'pidx' => $request->pidx
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            Log::info('Khalti Verification Response:', $responseData);

            if (isset($responseData['status']) && $responseData['status'] === 'Completed') {
                // Map Khalti status to your payment status
                $status = match ($responseData['status']) {
                    'Completed' => 'COMPLETE',
                    'Pending' => 'PENDING',
                    'Refunded' => 'FULL_REFUND',
                    'Partially Refunded' => 'PARTIAL_REFUND',
                    'Expired' => 'CANCELLED',
                    'User canceled' => 'CANCELED',
                    default => 'AMBIGUOUS'
                };

                // Retrieve cart items from session or database
                $cartItems = Cart::where('user_id', auth()->id())->with('property')->get();
                DB::beginTransaction();
                try {
                    $invoiceCartItems = [];
                    foreach ($cartItems as $cartItem) {
                        // Save payment record
                        $payment = new Payments();
                        $payment->user_id = auth()->id();
                        $payment->property_id = $cartItem->property_id;
                        $payment->property_quantity = $cartItem->property_quantity;
                        $payment->payment_method = 'KHALTI';
                        $payment->status = $status;
                        $payment->transaction_code = $request->pidx;
                        $payment->transaction_uuid = $responseData['transaction_id'];
                        $payment->signature = null;
                        $payment->total_amount = $responseData['total_amount'] / 100;
                        $payment->payment_date = now();
                        $payment->save();

                        // Prepare invoice cart items
                        $invoiceCartItems[] = [
                            'property_name' => $cartItem->property->property_name,
                            'property_quantity' => $cartItem->property_quantity,
                            'property_price' => $cartItem->property->property_sell_price,
                        ];


                        // Update property quantity
                        $property = Propeerty::find($cartItem['property_id']);
                        if ($property) {
                            $property->property_quantity -= $cartItem['property_quantity'];  // Decrease available quantity
                            $property->property_booked_quantity += $cartItem['property_quantity'];  // Increase booked quantity
                            $property->save();
                        }

                        // Delete cart item
                        $cartItem->delete();
                    }

                    DB::commit();

                    return view('frontend.payments.invoice-bill.invoice', [
                        'transactionUuid' => $responseData['transaction_id'],
                        'transactionCode' => $request->pidx,
                        'paymentDate'     => now(),
                        'paymentMethod'   => 'KHALTI',
                        'status'          => $status,
                        'cartItems'       => $invoiceCartItems,
                        'totalAmount'     => $responseData['total_amount'] / 100,
                    ])->with('success', 'Your payment has been processed successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Payment save failed: ' . $e->getMessage());
                    return redirect()->route('khalti.failed')
                        ->with('error', 'Payment processing failed. Please contact support.');
                }
            }

            return redirect()->route('khalti.failed')
                ->with('error', 'Payment verification failed: ' . ($responseData['status'] ?? 'Unknown status'));
        } catch (RequestException $e) {
            Log::error('Khalti Payment Verification Error: ' . $e->getMessage());

            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody(), true);
                Log::error('Khalti Verification Error Response: ', $errorResponse);
            }

            return redirect()->route('khalti.failed')
                ->with('error', 'Payment verification failed. Please contact support.');
        }
    }
    private function purchaseOrderID($cartItems)
    {
        $user_id = auth()->id();
        $product_ids = implode(',', array_column($cartItems, 'product_id'));
        return 'ORDER-' . $user_id . '-' . $product_ids . '-' . time();
    }

    public function failed()
    {
        return view('frontend.payments.failure')->with('error', 'Payment failed. Please try again.');
    }
}
