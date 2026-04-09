<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageNotification;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        try {
            Mail::mailer('smtp')->to('admin@mawkost.id')->send(new ContactMessageNotification($contact));
        }
        catch (\Exception $e) {
            \Log::error('Could not send contact email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan membalas secepatnya.');
    }
}
