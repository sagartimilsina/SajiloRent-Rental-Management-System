<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request, $type)
    {
        $role = UserRoleManagement::where('role_name', $type)->first();
        $users = User::orderBy('created_at', 'desc')->where('role_id', $role->id)->select('id', 'name', 'email', 'role_id', 'phone', 'avatar', 'is_seeded', 'status')->paginate(30);
        $all_role = UserRoleManagement::where('role_name', '!=', $type)->get();
        $all_roles = UserRoleManagement::all();
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
}




