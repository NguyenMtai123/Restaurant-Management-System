<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification; // gửi email (nếu muốn)

class ContactCusController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($request->all());

        // Nếu muốn gửi email thông báo admin
        // Mail::to('admin@example.com')->send(new ContactNotification($contact));

        return response()->json([
            'success' => true,
            'message' => 'Tin nhắn của bạn đã được gửi thành công!'
        ]);
    }
}
