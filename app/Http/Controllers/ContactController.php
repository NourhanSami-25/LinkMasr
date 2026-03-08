<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Requests\ContactMessageRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(ContactMessageRequest $request)
    {
        try {
            ContactMessage::create($request->validated());
            
            return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.');
        }
    }

    public function admin()
    {
        $this->authorize('accesssetting', ['view']);
        
        $messages = ContactMessage::with('repliedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('contact.admin', compact('messages'));
    }

    public function show($id)
    {
        $this->authorize('accesssetting', ['view']);
        
        $message = ContactMessage::with('repliedBy')->findOrFail($id);
        
        // Mark as read if it's new
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }
        
        return view('contact.show', compact('message'));
    }

    public function reply(Request $request, $id)
    {
        $this->authorize('accesssetting', ['modify']);
        
        $request->validate([
            'admin_reply' => 'required|string|max:2000'
        ], [
            'admin_reply.required' => 'الرد مطلوب',
            'admin_reply.string' => 'الرد يجب أن يكون نص',
            'admin_reply.max' => 'الرد لا يجب أن يتجاوز 2000 حرف',
        ]);

        $message = ContactMessage::findOrFail($id);
        
        $message->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'تم حفظ الرد بنجاح!');
    }

    public function destroy($id)
    {
        $this->authorize('accesssetting', ['delete']);
        
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('contact.admin')->with('success', 'تم حذف الرسالة بنجاح!');
    }
}