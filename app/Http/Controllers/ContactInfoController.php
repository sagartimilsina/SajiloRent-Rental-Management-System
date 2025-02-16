<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first(); // Fetch the first contact info entry
        return view('backend.contact.index', compact('contactInfo'));
    }

    public function edit()
    {
        $contactInfo = ContactInfo::first();
        return view('backend.contact.edit', compact('contactInfo'));
    }

    public function update(Request $request)
    {
        $contactInfo = ContactInfo::first();
        $contactInfo->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'phone_2' => $request->phone,
            'email' => $request->email,
            'email_2' => $request->email,
            'social_links' => json_encode($request->social_links),
        ]);
        return redirect()->route('contact.index')->with('success', 'Contact Info updated successfully');
    }
}
