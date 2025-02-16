<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payments;
use App\Models\Propeerty;
use App\Models\Property_Review;
use Illuminate\Http\Request;
use App\Models\PropertyMessage;
use App\Models\UserRoleManagement;
use App\Models\Users_Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function index(Request $request, $type = null)
    {
        // Retrieve all roles for display
        $all_roles = UserRoleManagement::all();

        // Get the currently authenticated user's role (normalized to lowercase)
        $currentUserRole = strtolower(Auth::user()->role->role_name);

        $currentUserId = Auth::id();

        // Determine the selected role for filtering (normalized to lowercase)
        $role = UserRoleManagement::whereRaw('LOWER(role_name) = ?', [strtolower($type)])->first();

        if (!$role) {
            return redirect()->back()->with('error', 'Invalid role type specified.');
        }

        // Normalize the role name for comparison
        $normalizedRole = strtolower($role->role_name);

        if ($currentUserRole == 'super admin') {
            // If Super Admin, fetch all users by the specified role
            $users = User::orderBy('created_at', 'desc')
                ->where('role_id', $role->id)
                ->select('id', 'name', 'email', 'role_id', 'phone', 'avatar', 'is_seeded', 'status')
                ->paginate(30);
        } elseif ($currentUserRole == 'admin') {
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

            // Fetch user details for the unique user IDs
            $users = User::whereIn('id', $allUserIds)->paginate(30);



            // Count the total users interacted
            $totalUsersInteracted = $users->count();

            // Return the users interacted with
            return view('Backend.ManageUsers.users', compact('users', 'type', 'all_roles'));
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
