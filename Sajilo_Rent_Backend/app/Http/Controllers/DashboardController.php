<?php

namespace App\Http\Controllers;

use App\Models\Request_owner_lists;
use App\Models\User;
use App\Models\UserRoleManagement;
use Illuminate\Http\Request;

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
        return view('Backend.admin.admin_dashboard');
    }
}
