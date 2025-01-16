<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\TenantAgreementwithSystem;
use App\Models\UserRoleManagement;

class TenantAgreementwithSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {

    //     $role_id = Auth::user()->role_id;
    //     $role_name = UserRoleManagement::where('id', $role_id)->value('role_name');
    //     if ($role_name == 'Super Admin') {

    //         $status = $request->get('status', null); // Default to null if not provided
    //         $search = $request->get('search', null); // Default to null if not provided

    //         // Define colors for each status
    //         $statusColors = [
    //             'pending' => 'primary',
    //             'approved' => 'success',
    //             'rejected' => 'danger',
    //             'expired' => 'warning',
    //             'all' => 'secondary',
    //         ];

    //         $currentStatus = $status ?? 'all'; // Default to 'all' if status is null
    //         $statusColor = $statusColors[$currentStatus] ?? 'secondary'; // Default to 'secondary' if status is unknown

    //         // Filter request lists based on status and search term
    //         $agreement_lists = TenantAgreementwithSystem::orderBy('created_at', 'desc')
    //             ->with('user:id,name,email,phone,role_id', 'request:id,user_id,status,business_name');

    //         if ($status && $status !== 'all') {
    //             $agreement_lists->where('status', $status);
    //         }

    //         if ($search) {
    //             // Searching for the user's name
    //             $agreement_lists->whereHas('user', function ($query) use ($search) {
    //                 $query->where('name', 'like', '%' . $search . '%');
    //             });
    //         }

    //         $agreement_lists = $agreement_lists->paginate(20);

    //     } elseif ($role_name == 'Admin') {

    //         $status = $request->get('status', null); // Default to null if not provided
    //         $search = $request->get('search', null); // Default to null if not provided

    //         // Define colors for each status
    //         $statusColors = [
    //             'pending' => 'primary',
    //             'approved' => 'success',
    //             'rejected' => 'danger',
    //             'expired' => 'warning',
    //             'all' => 'secondary',
    //         ];

    //         $currentStatus = $status ?? 'all'; // Default to 'all' if status is null
    //         $statusColor = $statusColors[$currentStatus] ?? 'secondary'; // Default to 'secondary' if status is unknown

    //         $agreement_lists = TenantAgreementwithSystem::orderBy('created_at', 'desc')
    //             ->with('user:id,name,email,phone,role_id', 'request:id,user_id,status,business_name')
    //             ->where('user_id', Auth::user()->id)
    //             ->paginate(10);

    //         if ($status && $status !== 'all') {
    //             $agreement_lists->where('status', $status);

    //         }

    //         if ($search) {
    //             // Searching for the user's name
    //             $agreement_lists->whereHas('user', function ($query) use ($search) {
    //                 $query->where('name', 'like', '%' . $search . '%');
    //             });
    //         }

    //         $agreement_lists = $agreement_lists->paginate(10);


    //     }

    //     // Get the status and search term from the request



    //     return view('Backend.ManageTenantAgreement.lists', compact(
    //         'agreement_lists',

    //         'currentStatus',
    //         'statusColor'
    //     ));
    // }

    public function index(Request $request)
    {
        $roleId = Auth::user()->role_id;
        $roleName = UserRoleManagement::where('id', $roleId)->value('role_name');

        $statusColors = $this->getStatusColors();
        $currentStatus = $request->get('status', 'all');
        $statusColor = $statusColors[$currentStatus] ?? 'secondary';

        $agreement_lists = $this->filterAgreementList(
            $request,
            $roleName,
            $roleName === 'Admin' ? Auth::user()->id : null
        );

        return view('Backend.ManageTenantAgreement.lists', compact(
            'agreement_lists',
            'currentStatus',
            'statusColor'
        ));
    }

    private function getStatusColors()
    {
        return [
            'pending' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
            'expired' => 'warning',
            'all' => 'secondary',
        ];
    }

    private function filterAgreementList(Request $request, $roleName, $userId = null)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search', null);

        $query = TenantAgreementwithSystem::orderBy('created_at', 'desc')
            ->with('user:id,name,email,phone,role_id', 'request:id,user_id,status,business_name');

        if ($roleName === 'Admin' && $userId) {
            $query->where('user_id', $userId);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($roleName === 'Super Admin' ? 20 : 10);
    }


    public function generateAgreementPDF(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'request_id' => 'required|exists:request_owner_lists,id',
            'user_id' => 'required|exists:users,id',
            'id' => 'required|exists:tenant_agreementwith_systems,id',
        ]);

        // Find the agreement from the database
        $tenantAgreementwithSystem = TenantAgreementwithSystem::find($request->id);

        if (!$tenantAgreementwithSystem) {
            return response()->json([
                'message' => 'Agreement not found',
                'success' => false,
            ], 404);
        }

        // Extract the agreement text
        $agreement_text = $tenantAgreementwithSystem->agreement;

        // Generate the PDF
        $pdf = PDF::loadHTML($agreement_text);

        // Ensure the agreements directory exists
        $agreementsPath = storage_path('app/public/agreements');
        if (!File::exists($agreementsPath)) {
            File::makeDirectory($agreementsPath, 0755, true); // Create the directory with permissions
        }

        // Unlink (delete) the previous PDF if it exists
        if ($tenantAgreementwithSystem->agreement_file) {
            $previousFilePath = $agreementsPath . '/' . basename($tenantAgreementwithSystem->agreement_file);
            if (File::exists($previousFilePath)) {
                File::delete($previousFilePath);
            }
        }

        // Save the new PDF to the directory
        $filePath = 'agreements/agreement_' . time() . '.pdf';
        $pdf->save($agreementsPath . '/' . basename($filePath));

        // Store the file path in the database
        $tenantAgreementwithSystem->agreement_file = $filePath;
        $tenantAgreementwithSystem->save();

        // Return a JSON response
        return redirect()->route('tenants-agreements.index')->with('success', 'Agreement PDF generated successfully');
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
    public function show(TenantAgreementwithSystem $tenantAgreementwithSystem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenantAgreementwithSystem $tenantAgreementwithSystem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenantAgreementwithSystem $tenantAgreementwithSystem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tenantAgreementwithSystem = TenantAgreementwithSystem::onlyTrashed()->findOrFail($id);
        if ($tenantAgreementwithSystem->agreement_file) {
            $filePath = storage_path('app/public/' . $tenantAgreementwithSystem->agreement_file);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        $tenantAgreementwithSystem->forceDelete();
        return redirect()->route('tenants-agreements.index')->with('success', 'Agreement has been deleted permanently Successfully');

    }
    public function trash(Request $request)
    {

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
        $agreement_lists = TenantAgreementwithSystem::orderBy('created_at', 'desc')
            ->with('user:id,name,email,phone,role_id', 'request:id,user_id,status,business_name')
            ->onlyTrashed();

        if ($status && $status !== 'all') {
            $agreement_lists->where('status', $status);
        }

        if ($search) {
            // Searching for the user's name
            $agreement_lists->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $agreement_lists = $agreement_lists->paginate(20);


        return view('Backend.ManageTenantAgreement.trash', compact(
            'agreement_lists',

            'currentStatus',
            'statusColor'
        ));

    }

    public function delete($id)
    {

        $request_owner_lists = TenantAgreementwithSystem::findOrFail($id);
        $request_owner_lists->delete();
        return redirect()->route('tenants-agreements.index')->with('success', 'Agreement  Deleted Successfully');
    }

    public function restore($id)
    {
        $request_owner_lists = TenantAgreementwithSystem::withTrashed()->findOrFail($id);
        $request_owner_lists->restore();
        return redirect()->route('tenants-agreements.index')->with('success', 'Agreement Restored Successfully');
    }
}
