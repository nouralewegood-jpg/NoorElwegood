<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        // تعليم الرسالة كمقروءة
        if (!$message->is_read) {
            $message->is_read = 1;
            $message->save();
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * الحصول على أحدث الرسائل بتنسيق JSON
     */
    public function getLatest()
    {
        $messages = Message::where('is_read', 0)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'name' => $message->name,
                    'email' => $message->email,
                    'message' => Str::limit($message->message, 50),
                    'created_at' => $message->created_at->diffForHumans()
                ];
            });

        return response()->json([
            'messages' => $messages
        ]);
    }

    /**
     * تمييز جميع الرسائل كمقروءة
     */
    public function markAllRead()
    {
        Message::where('is_read', 0)->update(['is_read' => 1]);

        return response()->json(['message' => 'تم تمييز جميع الرسائل كمقروءة']);
    }

    /**
     * حذف الرسالة
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'تم حذف الرسالة بنجاح');
    }
}
