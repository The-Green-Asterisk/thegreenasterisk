<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        // validate the form data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($request['turing-test'] !== 'on') {
            return redirect()->back()->with('error', 'Nice try, Mr. Robot!');
        } else {
            // send the email
            Mail::to(config('mail.from.address'))->send(new ContactFormMail($request->all()));

            // redirect the user with a success message
            return redirect()->back()->with('success', 'Your message has been sent!');
        }
    }
}
