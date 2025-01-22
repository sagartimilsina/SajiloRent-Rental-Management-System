<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Blogs;
use App\Models\Abouts;
use App\Models\Gallery;
use App\Models\Propeerty;
use App\Models\Categories;
use App\Models\SliderImages;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use App\Models\Request_owner_lists;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SubCategories;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        $Sliders = SliderImages::where('slider_publish_status', 1)->orderBy('created_at', 'desc')->get();

        $categories = Categories::where('publish_status', 1)->orderBy('created_at', 'desc')->get();
        $abouts = Abouts::where('about_publish_status', 1)->first();
        $apartments = Propeerty::where('property_publish_status', 1)->orderBy('created_at', 'desc')->take(8);
        $galleries = Gallery::where('gallery_publish_status', 1)->get();
        $testimonials = Testimonials::where('testimonials_publish_status', 1)->get();
        $blogs = Blogs::where('blog_publish_status', 1)->orderBy('created_at', 'desc')->take(8)->get();


        return view('frontend.index', compact('Sliders', 'categories', 'abouts', 'apartments', 'galleries', 'testimonials', 'blogs'));
    }
    // In your Controller
    public function getSubcategories($id)
    {
        $subcategories = SubCategories::where('category_id', $id)->get();
        return response()->json($subcategories);
    }

    public function about()
    {
        return view('frontend.about');
    }
    public function blog()
    {
        $blogs = Blogs::where('blog_publish_status', 1)->orderBy('created_at', 'desc')->get();
        return view('frontend.blog', compact('blogs'));
    }
    public function blog_details($id)
    {
        $blog = Blogs::findOrFail($id);
        $similar_blogs = Blogs::where('blog_publish_status', 1)->where('id', '!=', $id)->orderBy('created_at', 'desc')->take(8)->get();
        return view('frontend.blog_detail', compact('blog', 'similar_blogs'));
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function gallery()
    {
        return view('frontend.gallery');
    }




    public function submitRequest(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:users,phone,' . $request->input('user_id'),

            'email_address' => 'required|email|max:255',
            'residential_address' => 'required|string|max:255',
            'national_id' => 'required|string|max:255',
            'govt_id_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'agree_terms' => 'accepted|required',

            // Optional fields
            'business_name' => 'nullable|string|max:255',
            'pan_registration_id' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'business_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $validated;
        if ($request->agree_terms == 'on') {
            $data['agree_terms'] = true;
        } else {
            $data['agree_terms'] = false;
        }
        if ($request->has('phone_number')) {

            $user_id = $request->input('user_id');
            $phone_number = $request->input('phone_number');
            $user = User::find($user_id);
            if ($user) {
                $user->phone = $phone_number;
                $user->save();
            }
        }
        // Handle the govt_id_proof file upload
        if ($request->hasFile('govt_id_proof')) {
            $gov_id_proof = $request->file('govt_id_proof');
            $gov_id_proof_name = uniqid() . '_' . $gov_id_proof->getClientOriginalName();
            $data['govt_id_proof'] = $gov_id_proof->storeAs('government_id_proof', $gov_id_proof_name, 'public');
        }

        // Handle the business_proof file upload
        if ($request->hasFile('business_proof')) {
            $business_proof = $request->file('business_proof');
            $business_proof_name = uniqid() . '_' . $business_proof->getClientOriginalName();
            $data['business_proof'] = $business_proof->storeAs('business_proofs', $business_proof_name, 'public');
        }

        try {
            // Save the data to the database
            $requestRecord = Request_owner_lists::create($data);

            // Notify Super Admin via email
            Mail::send('emails.Request_Owner.property_request_admin', ['data' => $data], function ($message) use ($data) {
                $message->to('timilsinasagar04@gmail.com', 'Super Admin')
                    ->subject('New Property Request Received')
                    ->from('timilsinasagar04@gmail.com', 'Sajilo Rent Team')
                    ->replyTo($data['email_address'], $data['full_name']);
            });

            // Notify User via email
            Mail::send('emails.Request_Owner.property_request_user', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email_address'], $data['full_name'])->subject('Your Property Request Submission');
                $message->from('timilsinasagar04@gmail.com', 'Sajilo Rent Team');
            });

            // Redirect back with success message
            return redirect()->back()->with('success', 'Your request has been submitted successfully!');
        } catch (\Exception $e) {
            // Log the error and show the error message
            Log::error('Error submitting property request: ' . $e->getMessage());
            return redirect()->back()->withErrors(['An error occurred while processing your request. Please try again.']);
        }
    }




}


