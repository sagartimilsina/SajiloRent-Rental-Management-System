<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Payments;
use App\Models\Propeerty;
use App\Models\Categories;
use App\Models\Contact;
use App\Models\Favourites;
use Illuminate\Http\Request;
use App\Models\SubCategories;
use App\Models\Users_Property;
use App\Models\Property_Review;
use App\Models\PropertyMessage;
use PhpParser\Builder\Property;
use App\Models\UserRoleManagement;
use Illuminate\Support\Facades\DB;
use App\Models\Request_owner_lists;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    // public function super_admin_dashboard()
    // {
    //     // Fetch role IDs in a single query and group them by role name
    //     $roles = UserRoleManagement::whereIn('role_name', ['Super Admin', 'Admin', 'User'])
    //         ->get()
    //         ->groupBy('role_name')
    //         ->map(fn($role) => $role->pluck('id')->toArray());

    //     $super_admin_role_ids = $roles['Super Admin'] ?? [];
    //     $admin_role_ids = $roles['Admin'] ?? [];
    //     $user_role_ids = $roles['User'] ?? [];

    //     // Get the total number of users for each role
    //     $total_users = User::count();
    //     $total_super_admins = User::whereIn('role_id', $super_admin_role_ids)->count();
    //     $total_admins = User::whereIn('role_id', $admin_role_ids)->count();
    //     $total_regular_users = User::whereIn('role_id', $user_role_ids)->count();

    //     // Reusable function to get request counts by status
    //     $getRequestCountByStatus = function ($status) {
    //         return Request_owner_lists::where('status', $status)
    //             ->select('user_id')
    //             ->groupBy('user_id')
    //             ->count();
    //     };

    //     // Count the number of unique users with requests by status
    //     $pending_request_applications = $getRequestCountByStatus('pending');
    //     $rejected_request_applications = $getRequestCountByStatus('rejected');
    //     $approved_request_applications = $getRequestCountByStatus('approved');
    //     $expired_request_applications = $getRequestCountByStatus('expired');

    //     // Fetch user registration counts grouped by day, week, month, and year
    //     $userEnrollmentsDaily = User::selectRaw('DATE(created_at) as day, COUNT(*) as count')
    //         ->groupBy('day')
    //         ->orderBy('day')
    //         ->get();

    //     $userEnrollmentsWeekly = User::selectRaw('WEEK(created_at) as week, COUNT(*) as count')
    //         ->groupBy('week')
    //         ->orderBy('week')
    //         ->get();

    //     $userEnrollmentsMonthly = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();

    //     $userEnrollmentsYearly = User::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
    //         ->groupBy('year')
    //         ->orderBy('year')
    //         ->get();

    //     // Convert data to arrays for the charts
    //     $labelsDaily = $userEnrollmentsDaily->pluck('day'); // X-axis labels (e.g., days)
    //     $dataDaily = $userEnrollmentsDaily->pluck('count'); // Y-axis data (counts)

    //     $labelsWeekly = $userEnrollmentsWeekly->pluck('week');
    //     $dataWeekly = $userEnrollmentsWeekly->pluck('count');

    //     $labelsMonthly = $userEnrollmentsMonthly->pluck('month');
    //     $dataMonthly = $userEnrollmentsMonthly->pluck('count');

    //     $labelsYearly = $userEnrollmentsYearly->pluck('year');
    //     $dataYearly = $userEnrollmentsYearly->pluck('count');

    //     // Payment details
    //     $totalPaymentAmount = Payments::select('transaction_uuid', DB::raw('MAX(total_amount) as total'))
    //         ->groupBy('transaction_uuid')
    //         ->get()
    //         ->sum('total');

    //     $todayPaymentAmount = Payments::whereDate('created_at', Carbon::today())
    //         ->select('transaction_uuid', DB::raw('MAX(total_amount) as total'))
    //         ->groupBy('transaction_uuid')
    //         ->get()
    //         ->sum('total');

    //     // Categories and Subcategories
    //     $total_categories = Categories::count();
    //     $total_subcategories = SubCategories::count();

    //     // Products
    //     $total_products = Propeerty::count();

    //     // Contact Responses
    //     $total_contact_responses = Contact::count();

    //     // Pass data to the view
    //     return view('Backend.admin.super_admin_dashboard', compact(
    //         'total_users',
    //         'total_super_admins',
    //         'total_admins',
    //         'total_regular_users',
    //         'pending_request_applications',
    //         'rejected_request_applications',
    //         'approved_request_applications',
    //         'expired_request_applications',
    //         'labelsDaily',
    //         'dataDaily',
    //         'labelsWeekly',
    //         'dataWeekly',
    //         'labelsMonthly',
    //         'dataMonthly',
    //         'labelsYearly',
    //         'dataYearly',
    //         'totalPaymentAmount',
    //         'todayPaymentAmount',
    //         'total_categories',
    //         'total_subcategories',
    //         'total_products',
    //         'total_contact_responses'
    //     ));
    // }

    public function super_admin_dashboard()
    {
        $roles = UserRoleManagement::whereIn('role_name', ['Super Admin', 'Admin', 'User'])
            ->get()
            ->groupBy('role_name')
            ->map(fn($role) => $role->pluck('id')->toArray());

        $super_admin_role_ids = $roles['Super Admin'] ?? [];
        $admin_role_ids = $roles['Admin'] ?? [];
        $user_role_ids = $roles['User'] ?? [];

        $total_users = User::count();
        $total_super_admins = User::whereIn('role_id', $super_admin_role_ids)->count();
        $total_admins = User::whereIn('role_id', $admin_role_ids)->count();
        $total_regular_users = User::whereIn('role_id', $user_role_ids)->count();

        $getRequestCountByStatus = fn($status) => Request_owner_lists::where('status', $status)
            ->select('user_id')
            ->groupBy('user_id')
            ->count();

        $pending_request_applications = $getRequestCountByStatus('pending');
        $rejected_request_applications = $getRequestCountByStatus('rejected');
        $approved_request_applications = $getRequestCountByStatus('approved');
        $expired_request_applications = $getRequestCountByStatus('expired');

        // Fetch daily, weekly, monthly, and yearly user enrollments
        $dailyEnrollments = User::whereDate('created_at', Carbon::today())
            ->count();

        $weeklyEnrollments = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $monthlyEnrollments = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $yearlyEnrollments = User::whereYear('created_at', now()->year)
            ->count();

        // Fetch newly created messages and reviews
        $newMessages = Contact::whereDate('created_at', Carbon::today())
            ->count();

        $todayPaymentAmount = Payments::whereDate('created_at', Carbon::today())
            ->select('transaction_uuid', DB::raw('MAX(total_amount) as total'))
            ->groupBy('transaction_uuid')->get()->sum('total');

        $totalPaymentAmount = Payments::select('transaction_uuid', DB::raw('MAX(total_amount) as total')) // Select the unique max per transaction
            ->groupBy('transaction_uuid') // Ensure unique transactions
            ->get()
            ->sum('total'); // Sum only distinct transactions

        $todayPaymentList = Payments::with(['user', 'property']) // Eager load user and property details
            ->whereDate('created_at', Carbon::today()) // Filter by today's date
            ->orderBy('created_at', 'desc') // Optional: Order by creation date
            ->get()
            ->groupBy('transaction_code'); // Group by transaction code

        return view('Backend.admin.super_admin_dashboard', [
            'total_users' => $total_users,
            'total_super_admins' => $total_super_admins,
            'total_admins' => $total_admins,
            'total_regular_users' => $total_regular_users,
            'pending_request_applications' => $pending_request_applications,
            'rejected_request_applications' => $rejected_request_applications,
            'approved_request_applications' => $approved_request_applications,
            'expired_request_applications' => $expired_request_applications,

            'totalPaymentAmount' => $totalPaymentAmount,
            'todayPaymentAmount' => $todayPaymentAmount,
            'total_categories' => Categories::count(),
            'total_subcategories' => SubCategories::count(),
            'total_products' => Propeerty::count(),
            'total_contact_responses' => Contact::count(),
            'dailyEnrollments' => $dailyEnrollments,
            'weeklyEnrollments' => $weeklyEnrollments,
            'monthlyEnrollments' => $monthlyEnrollments,
            'yearlyEnrollments' => $yearlyEnrollments,

            'newMessages' => $newMessages,

            'todayPaymentList' => $todayPaymentList


        ]);
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

        // Count categories, subcategories, and products created by the admin
        $total_categories_created_by_you = Categories::where('created_by', Auth::user()->id)->count();
        $total_subcategories_created_by_you = SubCategories::where('created_by', Auth::user()->id)->count();
        $total_product_created_by_you = Propeerty::where('created_by', Auth::user()->id)->count();

        // Get all properties created by the admin
        $adminId = Auth::user()->id;
        $properties = Propeerty::where('created_by', $adminId)->pluck('id');

        // Get unique user IDs from each interaction type
        $userIdsFromEnrollments = Users_Property::whereIn('property_id', $properties)->pluck('user_id')->unique();
        $userIdsFromPayments = Payments::whereIn('property_id', $properties)->pluck('user_id')->unique();
        $userIdsFromMessages = PropertyMessage::whereIn('property_id', $properties)->pluck('user_id')->unique();
        $userIdsFromReviews = Property_Review::whereIn('property_id', $properties)->pluck('user_id')->unique();

        // Combine all user IDs and get the unique count
        $allUserIds = $userIdsFromEnrollments
            ->concat($userIdsFromPayments)
            ->concat($userIdsFromMessages)
            ->concat($userIdsFromReviews)
            ->unique();


        $totalUsersInteracted = $allUserIds->count();



        $totalPaymentAmount = Payments::whereIn('property_id', $properties)
            ->select('transaction_uuid', DB::raw('MAX(total_amount) as total')) // Select the unique max per transaction
            ->groupBy('transaction_uuid') // Ensure unique transactions
            ->get()
            ->sum('total'); // Sum only distinct transactions


        $todayPaymentAmount = Payments::whereIn('property_id', $properties)
            ->whereDate('created_at', Carbon::today())
            ->select('transaction_uuid', DB::raw('MAX(total_amount) as total')) // Get the max amount per transaction
            ->groupBy('transaction_uuid') // Group by unique transaction UUID
            ->get()
            ->sum('total'); // Final sum of unique transactions






        $todayPaymentList = Payments::with(['user', 'property']) // Eager load user and property details
            ->whereDate('created_at', Carbon::today()) // Filter by today's date
            ->whereIn('property_id', $properties) // Filter by specific property IDs
            ->orderBy('created_at', 'desc') // Optional: Order by creation date
            ->get()
            ->groupBy('transaction_code'); // Group by transaction code










        // Fetch daily, weekly, monthly, and yearly user enrollments
        $dailyEnrollments = Users_Property::whereIn('property_id', $properties)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $weeklyEnrollments = Users_Property::whereIn('property_id', $properties)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $monthlyEnrollments = Users_Property::whereIn('property_id', $properties)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $yearlyEnrollments = Users_Property::whereIn('property_id', $properties)
            ->whereYear('created_at', now()->year)
            ->count();

        // Fetch newly created messages and reviews
        $newMessages = PropertyMessage::whereIn('property_id', $properties)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $newReviews = Property_Review::whereIn('property_id', $properties)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Pass data to the view
        return view('Backend.admin.admin_dashboard', compact(
            'super_admin_role_ids',
            'admin_role_ids',
            'user_role_ids',
            'total_categories_created_by_you',
            'total_subcategories_created_by_you',
            'total_product_created_by_you',
            'totalUsersInteracted',
            'totalPaymentAmount',
            'dailyEnrollments',
            'weeklyEnrollments',
            'monthlyEnrollments',
            'yearlyEnrollments',
            'newMessages',
            'newReviews',
            'todayPaymentList',
            'todayPaymentAmount'

        ));
    }

    // public function admin_dashboard()
    // {
    //     // Fetch role IDs in a single query and group them by role name
    //     $roles = UserRoleManagement::whereIn('role_name', ['Super Admin', 'Admin', 'User'])
    //         ->get()
    //         ->groupBy('role_name')
    //         ->map(fn($role) => $role->pluck('id')->toArray());

    //     $super_admin_role_ids = $roles['Super Admin'] ?? [];
    //     $admin_role_ids = $roles['Admin'] ?? [];
    //     $user_role_ids = $roles['User'] ?? [];

    //     // Get the total number of users for each role
    //     $total_users = User::count();
    //     $total_super_admins = User::whereIn('role_id', $super_admin_role_ids)->count();
    //     $total_admins = User::whereIn('role_id', $admin_role_ids)->count();
    //     $total_regular_users = User::whereIn('role_id', $user_role_ids)->count();

    //     // Reusable function to get request counts by status
    //     $getRequestCountByStatus = function ($status) {
    //         return Request_owner_lists::where('status', $status)
    //             ->select('user_id')
    //             ->groupBy('user_id')
    //             ->count();
    //     };

    //     // Count the number of unique users with requests by status
    //     $pending_request_applications = $getRequestCountByStatus('pending');
    //     $rejected_request_applications = $getRequestCountByStatus('rejected');
    //     $approved_request_applications = $getRequestCountByStatus('approved');
    //     $expired_request_applications = $getRequestCountByStatus('expired');


    //     // Fetch user registration counts grouped by day
    //     $userEnrollments = User::selectRaw('DATE(created_at) as day, COUNT(*) as count')
    //         ->groupBy('day')
    //         ->orderBy('day')
    //         ->get();

    //     // Convert data to arrays for the chart
    //     $labels = $userEnrollments->pluck('day'); // X-axis labels (e.g., days)
    //     $data = $userEnrollments->pluck('count'); // Y-axis data (counts)




    //     // Pass data to the view
    //     return view('Backend.admin.admin_dashboard', compact(
    //         'total_users',
    //         'total_super_admins',
    //         'total_admins',
    //         'total_regular_users',
    //         'pending_request_applications',
    //         'rejected_request_applications',
    //         'approved_request_applications',
    //         'expired_request_applications',
    //         'labels',
    //         'data'
    //     ));

    //     return view('Backend.admin.admin_dashboard');
    // }

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
