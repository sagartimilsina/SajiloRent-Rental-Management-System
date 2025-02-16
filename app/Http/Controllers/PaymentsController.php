<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\Contracts;
use App\Models\Propeerty;
use Illuminate\Http\Request;
use App\Models\Users_Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   


    public function index(Request $request)
    {
        // Get authenticated user details
        $auth_id = auth()->id();
        $user_role = auth()->user()->role->role_name;

        // Validate request inputs
        $request->validate([
            'search' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        // Fetch search and filter inputs
        $search = $request->input('search');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');

        // Base query
        $query = Payments::query();

        // Apply role-specific logic
        if ($user_role != 'Super Admin') {
            // Get property IDs owned by the user
            $propertyIds = Users_Property::where('user_id', $auth_id)->pluck('property_id');
            $query->whereIn('property_id', $propertyIds);
        }

        // Apply filters using `when` method
        $query->when(!empty($search), function ($q) use ($search) {
            $q->where('transaction_code', 'LIKE', '%' . $search . '%');
        })
            ->when(!empty($paymentMethod), function ($q) use ($paymentMethod) {
                $q->where('payment_method', $paymentMethod);
            })
            ->when(!empty($status), function ($q) use ($status) {
                $q->where('status', $status);
            });

        // Group and aggregate data
        $query->selectRaw('
                transaction_uuid,
                MAX(transaction_code) as transaction_code,
                MAX(payment_method) as payment_method,
                MAX(status) as status,
                SUM(total_amount) as total_amount,
                MAX(created_at) as created_at
            ')
            ->groupBy('transaction_uuid')
            ->orderBy('created_at', 'desc');

        // Paginate results with query parameters
        $propertyPayments = $query->with('property:id,property_name,property_sell_price', 'user:id,name,email,phone')
            ->paginate(10)
            ->appends($request->query()); // Preserve query parameters in pagination links

        // Pass data to the view
        return view('Backend.ManagePayment.index', compact('propertyPayments', 'search', 'status', 'paymentMethod'));
    }


    // public function index(Request $request)
    // {
    //     // Get authenticated user details
    //     $auth_id = auth()->id();
    //     $user_role = auth()->user()->role->role_name;

    //     // Fetch search and filter inputs
    //     $filters = $request->only(['search', 'status', 'payment_method']);

    //     // Base query
    //     $query = Payments::query();

    //     // Apply role-specific logic
    //     if ($user_role !== 'Super Admin') {
    //         $propertyIds = Users_Property::where('user_id', $auth_id)->pluck('property_id');
    //         $query->whereIn('property_id', $propertyIds);
    //     }

    //     // Apply filters
    //     if (!empty($filters['search'])) {
    //         $query->where('transaction_code', 'LIKE', "%{$filters['search']}%");
    //     }

    //     if (!empty($filters['payment_method'])) {
    //         $query->where('payment_method', $filters['payment_method']);
    //     }

    //     if (!empty($filters['status'])) {
    //         $query->where('status', $filters['status']);
    //     }

    //     // Group and aggregate data
    //     $propertyPayments = $query->select([
    //         'transaction_uuid',
    //         'transaction_code',
    //         'payment_method',
    //         'status',
    //         DB::raw('SUM(total_amount) as total_amount'),
    //         'created_at'
    //     ])
    //         ->groupBy([
    //             'transaction_uuid',
    //             'transaction_code',
    //             'payment_method',
    //             'status',
    //             'created_at',
    //         ])
    //         ->with([
    //             'property:id,property_name,property_sell_price',
    //             'user:id,name,email,phone'
    //         ])
    //         ->orderByDesc('created_at')
    //         ->paginate(10);

    //     return $propertyPayments;

    //     return view('Backend.ManagePayment.index', compact('propertyPayments'))
    //         ->with($filters);
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payments $payments)
    {
        //
    }

    public function paymentInvoice($transaction_uuid)
    {
        Log::info('transaction_uuid: ' . $transaction_uuid);

        // Fetch all payments with the same transaction_uuid
        $invoiceData = Payments::where('transaction_uuid', $transaction_uuid)
            ->with('property:id,property_name,property_sell_price', 'user:id,name,email,phone')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($invoiceData->isEmpty()) {
            return response()->json(['error' => 'Invoice not found.'], 404);
        }

        // Prepare cart items
        $cartItems = [];
        foreach ($invoiceData as $payment) {
            $cartItems[] = [
                'property_name'  => $payment->property->property_name,
                'property_quantity' => $payment->property_quantity,
                'property_price' => $payment->property->property_sell_price,
            ];
        }

        // Calculate total amount
        $totalAmount = $invoiceData->sum('total_amount');

        return response()->json([
            'transactionUuid' => $transaction_uuid,
            'transactionCode' => $invoiceData[0]->transaction_code,
            'paymentDate'     => \Carbon\Carbon::parse($invoiceData[0]->payment_date)->format('d M, Y'),
            'paymentMethod'   => $invoiceData[0]->payment_method,
            'status'          => $invoiceData[0]->status,
            'cartItems'       => $cartItems,
            'totalAmount'    => $totalAmount,
            'user'            => $invoiceData[0]->user

        ]);
    }
}
