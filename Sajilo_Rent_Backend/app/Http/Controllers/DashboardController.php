<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function super_admin_dashboard()
    {
        return view('Backend.admin.admin_dashboard');
    }
    public function users(){
        return view('Backend.admin.Manage_users.user_list');
    }
}
