<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact_us');
    }
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email', // Corrected validation rule
                'type' => 'required',
                'message' => 'required|string',
                'phone' => ['required', 'digits:9'], // exactly 9 digits
            ]);

            // Create a new bug report
            Contact::create($validated);

            // Flash a success message to the session
            return back()->with('success', 'Your message has been received!');
        } catch (\Exception $e) {
            // Flash an error message to the session
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
