<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class NewsletterController extends Controller
{
    /**
     * Handle newsletter subscription.
     */
    public function store(Request $request)
    {
        // Validate email input and enforce uniqueness
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'email.unique' => 'هذا البريد مسجل لدينا بالفعل.',
        ]);

        // Create subscription record
        NewsletterSubscription::create([
            'email' => $request->email,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('newsletter_success', 'تم الاشتراك في النشرة الإخبارية بنجاح.');
    }
}
