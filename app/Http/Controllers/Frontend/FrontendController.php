<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Request_owner_lists;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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


