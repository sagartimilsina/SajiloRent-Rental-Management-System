<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Payments;
use App\Models\Propeerty;
use App\Models\Favourites;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;
use App\Models\Request_owner_lists;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function super_admin_dashboard()
    {
        // Fetch role IDs in a single query and group them by role name
        $roles = UserRoleManagement::whereIn('role_name', ['Super Admin', 'Admin', 'User'])
            ->get()
            ->groupBy('role_name')
            ->map(fn($role) => $role->pluck('id')->toArray());

        $super_admin_role_ids = $roles['Super Admin'] ?? [];
        $admin_role_ids = $roles['Admin'] ?? [];
        $user_role_ids = $roles['User'] ?? [];

        // Get the total number of users for each role
        $total_users = User::count();
        $total_super_admins = User::whereIn('role_id', $super_admin_role_ids)->count();
        $total_admins = User::whereIn('role_id', $admin_role_ids)->count();
        $total_regular_users = User::whereIn('role_id', $user_role_ids)->count();

        // Reusable function to get request counts by status
        $getRequestCountByStatus = function ($status) {
            return Request_owner_lists::where('status', $status)
                ->select('user_id')
                ->groupBy('user_id')
                ->count();
        };

        // Count the number of unique users with requests by status
        $pending_request_applications = $getRequestCountByStatus('pending');
        $rejected_request_applications = $getRequestCountByStatus('rejected');
        $approved_request_applications = $getRequestCountByStatus('approved');
        $expired_request_applications = $getRequestCountByStatus('expired');


        // Fetch user registration counts grouped by day
        $userEnrollments = User::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Convert data to arrays for the chart
        $labels = $userEnrollments->pluck('day'); // X-axis labels (e.g., days)
        $data = $userEnrollments->pluck('count'); // Y-axis data (counts)




        // Pass data to the view
        return view('Backend.admin.admin_dashboard', compact(
            'total_users',
            'total_super_admins',
            'total_admins',
            'total_regular_users',
            'pending_request_applications',
            'rejected_request_applications',
            'approved_request_applications',
            'expired_request_applications',
            'labels',
            'data'
        ));
    }


    public function users()
    {
        return view('Backend.admin.Manage_users.user_list');
    }

    public function admin_dashboard()
    {
        // Fetch role IDs in a single query and group them by role name
        $roles = UserRoleManagement::whereIn('role_name', ['Super Admin', 'Admin', 'User'])
            ->get()
            ->groupBy('role_name')
            ->map(fn($role) => $role->pluck('id')->toArray());

        $super_admin_role_ids = $roles['Super Admin'] ?? [];
        $admin_role_ids = $roles['Admin'] ?? [];
        $user_role_ids = $roles['User'] ?? [];

        // Get the total number of users for each role
        $total_users = User::count();
        $total_super_admins = User::whereIn('role_id', $super_admin_role_ids)->count();
        $total_admins = User::whereIn('role_id', $admin_role_ids)->count();
        $total_regular_users = User::whereIn('role_id', $user_role_ids)->count();

        // Reusable function to get request counts by status
        $getRequestCountByStatus = function ($status) {
            return Request_owner_lists::where('status', $status)
                ->select('user_id')
                ->groupBy('user_id')
                ->count();
        };

        // Count the number of unique users with requests by status
        $pending_request_applications = $getRequestCountByStatus('pending');
        $rejected_request_applications = $getRequestCountByStatus('rejected');
        $approved_request_applications = $getRequestCountByStatus('approved');
        $expired_request_applications = $getRequestCountByStatus('expired');


        // Fetch user registration counts grouped by day
        $userEnrollments = User::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Convert data to arrays for the chart
        $labels = $userEnrollments->pluck('day'); // X-axis labels (e.g., days)
        $data = $userEnrollments->pluck('count'); // Y-axis data (counts)




        // Pass data to the view
        return view('Backend.admin.admin_dashboard', compact(
            'total_users',
            'total_super_admins',
            'total_admins',
            'total_regular_users',
            'pending_request_applications',
            'rejected_request_applications',
            'approved_request_applications',
            'expired_request_applications',
            'labels',
            'data'
        ));

        return view('Backend.admin.admin_dashboard');
    }

    public function user_dashboard()
    {
        return view('frontend.profile.Profile');
    }

    public function myCart()
    {



        if (request()->ajax()) {
            $id = Auth::id();
            $cartItems = Cart::with(['property.subcategory.category', 'user'])
                ->where('user_id', $id)
                ->get();
            $cartCount = $cartItems->count();
            return view('frontend.profile.partials.cart', compact('cartItems', 'cartCount'));
        }
        return view('frontend.profile.Profile');
    }

    public function myPaymentHistory()
    {
        if (request()->ajax()) {
            $myPayment = Payments::with([
                'property:id,property_name,property_sell_price',
                'user:id,name'
            ])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get()

                ->groupBy('transaction_uuid');  // Grouping by transaction_uuid

            return view('frontend.profile.partials.my-payment-history', compact('myPayment'));
        }

        return view('frontend.profile.Profile');
    }


    public function myFavourites()
    {
        if (request()->ajax()) {
            $favoriteIds = [];

            if (Auth::check()) {
                $favoriteIds = Favourites::where('user_id', Auth::id())
                    ->where('favourite_status', true)
                    ->pluck('property_id')
                    ->toArray();
            }

            // Fetch only properties that are in the favorites list
            $apartments = Propeerty::whereIn('id', $favoriteIds)
                ->where('property_publish_status', 1)
                ->orderBy('created_at', 'desc')
                ->get();

            // Return only the tbody content
            return view('frontend.profile.partials.my-favourite', compact('favoriteIds', 'apartments'))->render();
        }

        return view('frontend.profile.Profile');
    }


    public function editProfile()
    {
        if (request()->ajax()) {
            return view('frontend.profile.partials.edit-profile');
        }
        return view('frontend.profile.Profile');
    }

    public function myChats()
    {
        if (request()->ajax()) {
            return view('frontend.profile.partials.chat');
        }

        return view('frontend.profile.Profile');
    }


    // public function paymentInvoice($transaction_uuid)
    // {
    //     try {
    //         // Prepare data for the invoice
    //         $invoiceData = Payments::where('transaction_uuid', $transaction_uuid)
    //             ->where('user_id', Auth::id())
    //             ->with('property:id,property_name,property_sell_price', 'user:id,name')
    //             ->first();

    //         if (!$invoiceData) {
    //             return response()->json(['error' => 'Invoice not found.'], 404);
    //         }

    //         $cartItems = [
    //             'property_name'  => $invoiceData->property->property_name,
    //             'property_quantity' => $invoiceData->property_quantity,
    //             'property_price' => $invoiceData->property->property_sell_price,
    //         ];

    //         $view = view('frontend.payments.invoice-bill.invoice', [
    //             'transactionUuid' => $transaction_uuid,
    //             'transactionCode' => $invoiceData->transaction_code,
    //             'paymentDate'     => $invoiceData->payment_date,
    //             'paymentMethod'   => $invoiceData->payment_method,
    //             'status'          => $invoiceData->status,
    //             'cartItems'       => $cartItems,
    //             'totalAmount'     => $invoiceData->total_amount,
    //         ])->render();

    //         return response()->json(['html' => $view]);
    //     } catch (\Exception $e) {
    //         Log::error('Payment save failed: ' . $e->getMessage());
    //         return response()->json(['error' => 'Payment processing failed.'], 500);
    //     }
    // }

    public function paymentInvoice($transaction_uuid)
    {
        Log::info('transaction_uuid: ' . $transaction_uuid);
        // try {
        // Prepare data for the invoice
        $invoiceData = Payments::where('transaction_uuid', $transaction_uuid)
            ->where('user_id', Auth::id())
            ->with('property:id,property_name,property_sell_price', 'user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();


        if (!$invoiceData) {
            return response()->json(['error' => 'Invoice not found.'], 404);
        }



        $cartItems = [];
        foreach ($invoiceData as $payment) {
            $cartItems[] = [
                'property_name'  => $payment->property->property_name,
                'property_quantity' => $payment->property_quantity,
                'property_price' => $payment->property->property_sell_price,
            ];
        }

        return response()->json([
            'transactionUuid' => $transaction_uuid,
            'transactionCode' => $invoiceData[0]->transaction_code,
            'paymentDate'     => \Carbon\Carbon::parse($invoiceData[0]->payment_date)->format('d M, Y'),
            'paymentMethod'   => $invoiceData[0]->payment_method,
            'status'          => $invoiceData[0]->status,
            'cartItems'       => $cartItems,
            'totalAmount'    => $invoiceData[0]->total_amount,

        ]);
        // } catch (\Exception $e) {
        //     Log::error('Payment save failed: ' . $e->getMessage());
        //     return response()->json(['error' => 'Payment processing failed.'], 500);
        // }
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'current_location' => 'nullable|string|max:255',
            'permanent_location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',

        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->with('error', 'Validation failed: ' . implode(', ', $validatedData->errors()->all()));
        }
        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            // Delete old file if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Store new image
            $user->avatar = $request->file('profile_image')->store('avatars', 'public');
        }

        // Handle Document Upload
        if ($request->hasFile('file')) {
            // Delete old document if it exists
            if ($user->documents && Storage::disk('public')->exists($user->documents)) {
                Storage::disk('public')->delete($user->documents);
            }
            // Store new document
            $user->documents = $request->file('file')->store('documents', 'public');
        }

        // Update user details
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'current_location' => $request->input('current_location'),
            'permanent_location' => $request->input('permanent_location'),
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
