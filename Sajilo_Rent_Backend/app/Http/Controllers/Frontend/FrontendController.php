<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function about()
    {
        return view('frontend.about');
    }
    public function blog()
    {
        return view('frontend.blog');
    }
    public function blog_details()
    {
        return view('frontend.blog_detail');
    }
    public function contact()
    {
        return view('frontend.contact');
    }
}
