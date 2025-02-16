<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to Database
        $contact = Contact::create($validated);

        // Send Email
        Mail::to('aashishpaudel.xdezo@gmail.com')->send(new ContactMail($contact));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
