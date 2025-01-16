<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\TenantAgreementwithSystem;
use Illuminate\Support\Facades\Mail;

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

        return redirect()->back()->with('success', 'Agreement PDF generated successfully');
    }


    public function update_agreement(Request $request, $id)
    {
        $request->validate([
            'agreement_text' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        // try {
            // Find the user and validate existence
            $user = User::find($request->user_id);
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }

            // Find the agreement and validate existence
            $agreement = TenantAgreementwithSystem::find($id);
            if (!$agreement) {
                return redirect()->back()->with('error', 'Agreement not found');
            }

            // Update the agreement
            $agreement->agreement = $request->agreement_text;
            $agreement->save();

            // Admin email address
            $adminEmail = 'timilsinasagar.tukisoft@gmail.com'; // Replace with the actual admin email address

            // Send email notification to admin
            $details = [
                'user_name' => $user->name,
                'user_email' => $user->email,
            ];

            Mail::send('emails.Agreement.agreement_file_update_for_admin', $details, function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                    ->subject('User Agreement Updated');
            });

            return redirect()->back()->with('success', 'Agreement updated successfully and admin notified.');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Failed to update agreement: ' . $e->getMessage());
        // }
    }


    public function verify(Request $request, $id)
    {


        $request->validate([
            'user_id' => 'required|exists:users,id',
            'agreement_status' => 'required|in:1,0',
        ]);
        // try {
        $user = User::where('id', $request->user_id)->select('name', 'email')->first();

        $tenantAgreementwithSystem = TenantAgreementwithSystem::where('id', $id)
            ->orWhere('user_id', $request->user_id)
            ->first();

        $tenantAgreementwithSystem->agreement_status = $request->agreement_status;

        $tenantAgreementwithSystem->save();
        $loginRoute = route('login');

        $details = [
            'user' => $user,
            'loginRoute' => $loginRoute
        ];

        Mail::send('emails.Agreement.agreement_file_approved', $details, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Agreement Has Been Approved');
        });

        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Failed to verify agreement: ' . $e->getMessage());
        // }


        return redirect()->route('tenants-agreements.index')->with('success', 'Agreement Approved Successfully');
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
