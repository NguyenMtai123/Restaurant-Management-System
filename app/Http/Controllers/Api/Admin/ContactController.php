<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Danh sách liên hệ
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('subject', 'like', "%{$keyword}%");
            });
        }

        $contacts = $query->latest()->paginate(10)->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    // Xem chi tiết liên hệ
    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    // Xóa liên hệ
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Xóa liên hệ thành công');
    }

    // Đánh dấu đã đọc / chưa đọc (tùy chọn)
    public function toggleRead(Contact $contact)
    {
        $contact->update(['is_read' => !$contact->is_read]);

        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Cập nhật trạng thái liên hệ');
    }
}
