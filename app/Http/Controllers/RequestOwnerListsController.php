<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RejectMail;
use App\Mail\ApproveMail;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;


use App\Models\Request_owner_lists;
use Illuminate\Support\Facades\Mail;
use App\Models\TenantAgreementwithSystem;

class RequestOwnerListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userroles = UserRoleManagement::whereIn('role_name', ['Admin', 'User'])->get();

        // Get the status and search term from the request
        $status = $request->get('status', null); // Default to null if not provided
        $search = $request->get('search', null); // Default to null if not provided

        // Define colors for each status
        $statusColors = [
            'pending' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
            'expired' => 'warning',
            'all' => 'secondary',
        ];

        $currentStatus = $status ?? 'all'; // Default to 'all' if status is null
        $statusColor = $statusColors[$currentStatus] ?? 'secondary'; // Default to 'secondary' if status is unknown

        // Filter request lists based on status and search term
        $request_lists = Request_owner_lists::orderBy('created_at', 'desc')
            ->with('user:id,name,email,phone,role_id');

        if ($status && $status !== 'all') {
            $request_lists->where('status', $status);
        }

        if ($search) {
            // Searching for the user's name
            $request_lists->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $request_lists = $request_lists->paginate(20);

        return view('Backend.ManageRequestApplication.lists', compact(
            'request_lists',
            'userroles',
            'currentStatus',
            'statusColor'
        ));
    }


    public function approve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,expired',
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:user_role_management,id',
            // 'agreement_text' => 'required|string',
        ]);

        try {
            $user_role = User::find($request->user_id);
            if (!$user_role) {
                return redirect()->route('RequestOwnerLists.index')->with('error', 'User not found');
            }

            $user_role->role_id = $request->role_id;
            $user_role->save();

            $request_status = Request_owner_lists::find($id);
            if (!$request_status) {
                return redirect()->route('RequestOwnerLists.index')->with('error', 'Request not found');
            }
            if ($request_status->status !== 'pending') {
                return redirect()->route('RequestOwnerLists.index')->with('error', 'This record has already been updated and cannot be modified again.');
            }

            $request_status->status = $request->status;
            $request_status->save();

            if ($request->filled('agreement_text')) {
                TenantAgreementwithSystem::create([
                    'request_id' => $request_status->id,
                    'user_id' => $request->user_id,
                    'agreement' => $request->agreement_text ?? '',
                ]);
            }
            // Send email notification
            Mail::to($user_role->email)->send(new ApproveMail($user_role));


            return redirect()->route('RequestOwnerLists.index')->with('success', 'Request Approved Successfully');
        } catch (\Exception $e) {
            return redirect()->route('RequestOwnerLists.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,expired',
            'user_id' => 'required|exists:users,id',
            'reason' => 'required|string',

        ]);

        // try {
        $user = User::find($request->user_id);
        if (!$user) {
            return redirect()->route('RequestOwnerLists.index')->with('error', 'User not found');
        }

        $user_email = $user->email;
        $request_status = Request_owner_lists::find($id);
        if ($request_status->status !== 'pending') {
            return redirect()->route('RequestOwnerLists.index')->with('error', 'This record has already been updated and cannot be modified again.');
        }
        if (!$request_status) {
            return redirect()->route('RequestOwnerLists.index')->with('error', 'Request not found');
        }
        $request_status->status = $request->status;
        $request_status->reason = $request->reason;
        $request_status->save();
        Mail::to($user_email)->send(new RejectMail($request_status, $user));
        return redirect()->route('RequestOwnerLists.index')->with('success', 'Request Rejected Successfully');
        // } catch (\Exception $e) {
        //     return redirect()->route('RequestOwnerLists.index')->with('error', 'Error: ' . $e->getMessage());
        // }
    }

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
    public function show(Request_owner_lists $request_owner_lists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request_owner_lists $request_owner_lists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Request_owner_lists $request_owner_lists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $request_owner_lists = Request_owner_lists::findOrFail($id);
        $request_owner_lists->delete();
        return redirect()->route('RequestOwnerLists.index')->with('success', 'Request Deleted Successfully');
    }

    public function trash(Request $request)
    {
        // Fetch the search term from the request
        $search = $request->input('search');

        // Build a base query for trashed records
        $query = Request_owner_lists::onlyTrashed()->with('user:id,name,email,role_id,phone');

        // Apply a search filter for the user's name
        if (!empty($search)) {
            $query->whereHas('user:id,name,email,role_id,phone,', function ($subQuery) use ($search) {
                $subQuery->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        // Paginate results with a limit of 10 per page
        $request_owner_lists = $query->paginate(10);

        // Return the view with data
        return view('Backend.ManageRequestApplication.trash', compact('request_owner_lists', 'search'));
    }



    public function restore($id)
    {
        $request_owner_lists = Request_owner_lists::withTrashed()->findOrFail($id);
        $request_owner_lists->restore();
        return redirect()->route('RequestOwnerLists.index')->with('success', 'Request Restored Successfully');
    }
    public function delete($id)
    {
        $request_owner_lists = Request_owner_lists::withTrashed()->findOrFail($id);
        $request_owner_lists->forceDelete();
        return redirect()->route('RequestOwnerLists.index')->with('success', 'Request Deleted Successfully');

    }
}
