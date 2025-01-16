<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function index(Request $request, $type = null)
    {
        // Retrieve all roles for display
        $all_roles = UserRoleManagement::all();

        // Get the currently authenticated user's role
        $currentUserRole = Auth::user()->role->role_name;
        $currentUserId = Auth::id();

        // Determine the selected role for filtering
        $role = UserRoleManagement::where('role_name', $type)->first();
        if (!$role) {
            return redirect()->back()->with('error', 'Invalid role type specified.');
        }

        if ($currentUserRole == 'Super Admin') {
            // If Super Admin, fetch all users by the specified role
            $users = User::orderBy('created_at', 'desc')
                ->where('role_id', $role->id)
                ->select('id', 'name', 'email', 'role_id', 'phone', 'avatar', 'is_seeded', 'status')
                ->paginate(30);

        } elseif ($currentUserRole == 'Admin') {
            return 'after frontend is finished , need to code';
            //need to code after frontend.
            // // If Admin, fetch users created by this admin or involved in their products

            // // Fetch users created by this admin
            // $createdByAdmin = User::where('company_id', $currentUserId)->pluck('id');

            // // Fetch users involved with this admin's products (reviews/rentals)
            // $productRelatedUsers = DB::table('property__reviews')
            //     ->where('user_id', $currentUserId)  // Assuming admin_id tracks the product owner
            //     ->orWhere('property_id', $currentUserId)  // Assuming rented_by indicates the user who rented
            //     ->pluck('user_id');

            // // Combine user IDs and fetch unique users
            // $userIds = $createdByAdmin->merge($productRelatedUsers)->unique();

            // // Fetch the user data
            // $users = User::whereIn('id', $userIds)
            //     ->orderBy('created_at', 'desc')
            //     ->select('id', 'name', 'email', 'role_id', 'phone', 'avatar', 'is_seeded', 'status')
            //     ->paginate(30);
        } else {
            return redirect()->back()->with('error', 'You are not authorized to view this resource.');
        }

        return view('Backend.ManageUsers.users', compact('users', 'type', 'all_roles'));
    }


    public function search(Request $request, $type)
    {
        Log::info($type);

        $role = UserRoleManagement::where('role_name', $type)->first();

        // Fetch users based on search query
        $users = User::where('role_id', $role->id)
            ->where('name', 'like', '%' . $request->query('query') . '%')
            ->select('id', 'name', 'email', 'phone', 'avatar', 'is_seeded', 'status') // Adjusted fields for your needs
            ->paginate(30);

        // Return the users and pagination data in the response
        return response()->json([
            'users' => $users->items(),
            'pagination' => (string) $users->links()
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        Log::info($request->all());
        $user = User::find($id);
        // Check if the user exists
        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['message' => 'User not found.'], 404);
            }
            return redirect()->back()->with('error', 'User not found.');
        }
        // Restrict updates to seeded users
        if ($user->is_seeded !== 0) {
            if ($request->ajax()) {
                return response()->json(['message' => 'You cannot change the role of a seeded user.'], 403);
            }
            return redirect()->back()->with('error', 'You cannot change the role of a seeded user.');
        }
        // Validate the incoming request
        $validated = $request->validate([
            'role' => 'required|exists:user_role_management,id', // Ensure the role exists in the roles table
        ]);
        // Update the user's role
        $user->role_id = $validated['role'];
        $user->save();
        // Handle AJAX response
        if ($request->ajax()) {
            return response()->json(['message' => 'Role updated successfully.', 'user' => $user]);
        }
        // Handle Blade-based response
        return redirect()->back()->with('success', 'Role updated successfully.');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        if ($user->is_seeded !== 0) {

            return redirect()->back()->with('error', 'You cannot delete a seeded user .');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function admin_index_users(Request $request)
    {


        $users = User::orderBy('created_at', 'desc')->select('id', 'name', 'email', 'role_id', 'phone', 'avatar', 'is_seeded', 'status')->paginate(30);
        return view('Backend.ManageUsers.users', compact('users'));
    }
}




