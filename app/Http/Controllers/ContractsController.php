<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payments;
use App\Models\Contracts;
use App\Models\Propeerty;
use App\Models\Users_Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $contracts = Contracts::with('property', 'user')->orderBy('created_at', 'desc')->paginate(10);
    //     return view('backend.ManageContracts.lists', compact('contracts'));
    // }


    public function index(Request $request)
    {

        $auth_id = auth()->user()->id;
        $user_role = auth()->user()->role->role_name;


        $status = $request->input('status');
        $contractType = $request->input('contract_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query based on user role
        if ($user_role == 'Super Admin') {
            $query = Contracts::query();
        } else {
            // Get product IDs owned by admin
            $productIds = Users_Property::where('user_id', $auth_id)->pluck('property_id');
            $query = Contracts::with('user', 'property')->whereIn('property_id', $productIds)
                ->orderBy('created_at', 'desc');
        }

        // Search by contract code (partial match)


        // Filter by contract type (exact match)
        if (!empty($contractType)) {
            $query->where('contract_type', $contractType);
        }

        // Filter by status
        if (!empty($status)) {
            $query->where('contract_status', $status);
        }

        // Filter by date range
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Order by created_at descending
        $query->orderBy('created_at', 'desc');

        // Paginate the results (e.g., 10 items per page)
        $contracts = $query->paginate(10);

        return view('Backend.ManageContracts.index', compact('contracts', 'status', 'contractType', 'startDate', 'endDate'));
    }

    public function fetchPaidUsers($productId)
    {
        // try {
        // Fetch unique user_ids with COMPLETE status for the given product
        $userIds = Payments::where('property_id', $productId)
            ->where('status', 'COMPLETE')
            ->pluck('user_id')
            ->unique();

        // Fetch user details using the retrieved unique user IDs
        $users = User::whereIn('id', $userIds)->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);

        // } catch (\Exception $e) {
        //     Log::error('Error fetching paid users: ' . $e->getMessage(), [
        //         'product_id' => $productId,
        //         'trace' => $e->getTraceAsString()
        //     ]);

        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Error fetching users'
        //     ], 500);
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $products = Propeerty::orderBy('created_at', 'desc')
            ->where('property_publish_status', 1)
            ->where('created_by', auth()->user()->id)
            ->get();
        return view('backend.ManageContracts.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'property_id' => 'required|exists:propeerties,id',
            'user_id' => 'required|exists:users,id',
            'contract_type' => 'required',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx',
            'contract_status' => 'required',
        ]);

        $data = $request->only(['property_id', 'user_id', 'contract_type', 'contract_start_date', 'contract_end_date', 'contract_status']);

        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = $request->file('contract_file')->storePublicly('contracts', 'public');
        }


        Contracts::create($data);

        return redirect()->route('property-contracts.index')->with('success', 'Contract created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Contracts $contracts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $products = Propeerty::orderBy('created_at', 'desc')
            ->where('property_publish_status', 1)
            ->where('created_by', auth()->user()->id)
            ->get();


        $contract = Contracts::with('property', 'user')->find($id);
        $user_id = $contract->user_id;

        $users = User::where('id', $user_id)->get();

        return view('backend.ManageContracts.create', compact('products', 'contract', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'property_id' => 'required|exists:propeerties,id',
            'user_id' => 'required|exists:users,id',
            'contract_type' => 'required',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx',
            'contract_status' => 'required',
        ]);

        $data = $request->only(['product_id', 'user_id', 'contract_type', 'contract_start_date', 'contract_end_date', 'contract_status']);

        $contract = Contracts::findOrFail($id);

        if ($request->hasFile('contract_file')) {
            if ($contract->contract_file) {
                Storage::delete($contract->contract_file);
            }
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        } else {
            $data['contract_file'] = $contract->contract_file;
        }

        $contract->update($data);

        return redirect()->route('property-contracts.index')->with('success', 'Contract updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contract = Contracts::findOrFail($id);
        if ($contract->contract_file) {
            Storage::delete($contract->contract_file);
        }
        $contract->delete();
        return redirect()->route('property-contracts.index')->with('success', 'Contract deleted successfully!');
    }
}
