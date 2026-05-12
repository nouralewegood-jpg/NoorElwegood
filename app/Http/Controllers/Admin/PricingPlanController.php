<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PricingPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('csrf');

        // Add Content Security Policy headers
        $this->middleware(function ($request, $next) {
            $response = $next($request);

            if (method_exists($response, 'header')) {
                $response->header(
                    'Content-Security-Policy',
                    "default-src 'self'; " .
                        "script-src 'self' 'unsafe-inline' 'unsafe-eval'; " .
                        "style-src 'self' 'unsafe-inline'; " .
                        "img-src 'self' data:; " .
                        "connect-src 'self'; " .
                        "font-src 'self'; " .
                        "object-src 'none'; " .
                        "frame-src 'self'; " .
                        "frame-ancestors 'self'; " .
                        "form-action 'self'; " .
                        "base-uri 'self'; " .
                        "block-all-mixed-content"
                );
                $response->header('X-XSS-Protection', '1; mode=block');
                $response->header('X-Frame-Options', 'DENY');
                $response->header('X-Content-Type-Options', 'nosniff');
                $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
                $response->header('Permissions-Policy', 'geolocation=(), camera=(), microphone=()');
            }

            return $response;
        });
    }

    /**
     * Store a newly created pricing plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Rate limiting: 5 attempts per minute per IP
        $ipAddress = $request->ip();
        $key = "pricing_plan_create_{$ipAddress}";

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            Log::warning("Rate limit exceeded on pricing plan creation", [
                'ip' => $ipAddress,
                'seconds_remaining' => $seconds
            ]);
            return back()
                ->with('error', "محاولات كثيرة جدًا. يرجى المحاولة مرة أخرى بعد {$seconds} ثوانٍ.")
                ->withInput();
        }

        RateLimiter::hit($key, 60); // Remember for 60 seconds

        // Validate honeypot field to prevent bot submissions
        if ($request->filled('honeypot')) {
            Log::warning("Bot submission detected", [
                'ip' => $ipAddress,
                'user_agent' => $request->userAgent()
            ]);
            return back()->with('error', 'Bot submission detected.');
        }

        // Validate submission time to prevent automated form submissions
        $submissionTime = $request->input('submission_time', 0);
        if (time() - $submissionTime < 2) {  // Form submitted too quickly (less than 2 seconds)
            Log::warning("Form submitted too quickly", [
                'ip' => $ipAddress,
                'time_difference' => time() - $submissionTime,
                'user_agent' => $request->userAgent()
            ]);
            return back()->with('error', 'The form was submitted too quickly. Please try again.');
        }

        // Validate security token
        if (!$request->filled('security_token') || strlen($request->security_token) < 10) {
            Log::warning("Invalid security token", [
                'ip' => $ipAddress,
                'token_length' => $request->filled('security_token') ? strlen($request->security_token) : 0,
                'user_agent' => $request->userAgent()
            ]);
            return back()->with('error', 'Invalid security token.');
        }

        // Check token expiration
        list($timestamp, $hash) = array_pad(explode(':', $request->security_token, 2), 2, '');
        if (!is_numeric($timestamp) || time() - (int)$timestamp > 3600) {
            Log::warning("Expired security token", [
                'ip' => $ipAddress,
                'token_age' => is_numeric($timestamp) ? time() - (int)$timestamp : 'invalid',
                'user_agent' => $request->userAgent()
            ]);
            return back()->with('error', 'Security token expired. Please refresh the page and try again.');
        }

        // Validate the request data with more comprehensive rules
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^<>&\'\"]*$/',
                function ($attribute, $value, $fail) {
                    // Additional validation for potential XSS attempts
                    if (preg_match('/(script|javascript|on\w+\s*=|alert\s*\(|\bdata\s*:)/i', $value)) {
                        $fail('The :attribute contains potentially malicious content.');
                    }
                },
            ],
            'price' => 'required|numeric|min:0|max:100000',
            'currency' => [
                'nullable',
                'string',
                'max:10',
                'regex:/^[^<>&\'\"]*$/',
            ],
            'duration' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[^<>&\'\"]*$/',
            ],
            'btn_text' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[^<>&\'\"]*$/',
            ],
            'btn_url' => [
                'nullable',
                'string',
                'max:255',
                'url',
                'regex:/^[^<>\'"]*$/',
            ],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'security_token' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Sanitize all inputs before saving
        $sanitizedData = $this->sanitizeData($request->only([
            'title',
            'price',
            'currency',
            'duration',
            'btn_text',
            'btn_url'
        ]));

        try {
            // Create new pricing plan
            $plan = new PricingPlan();
            $plan->title = $sanitizedData['title'];
            $plan->price = $sanitizedData['price'];
            $plan->currency = $sanitizedData['currency'];
            $plan->duration = $sanitizedData['duration'];
            $plan->btn_text = $sanitizedData['btn_text'];
            $plan->btn_url = $sanitizedData['btn_url'];
            $plan->is_active = $request->has('is_active');
            $plan->is_featured = $request->has('is_featured');
            $plan->save();

            return redirect()->back()->with('success', 'تمت إضافة خطة التسعير بنجاح');
        } catch (\Exception $e) {
            Log::error("Error creating pricing plan", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'حدث خطأ أثناء إنشاء خطة التسعير. يرجى المحاولة مرة أخرى.');
        }
    }

    /**
     * Update the specified pricing plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Rate limiting: 5 attempts per minute per IP
        $ipAddress = $request->ip();
        $key = "pricing_plan_update_{$ipAddress}";

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->with('error', "محاولات كثيرة جدًا. يرجى المحاولة مرة أخرى بعد {$seconds} ثوانٍ.")
                ->withInput();
        }

        RateLimiter::hit($key, 60); // Remember for 60 seconds

        // Validate submission time to prevent automated form submissions
        $submissionTime = $request->input('submission_time', 0);
        if (time() - $submissionTime < 2) {  // Form submitted too quickly (less than 2 seconds)
            return back()->with('error', 'The form was submitted too quickly. Please try again.');
        }

        // Validate security token
        if (!$request->filled('security_token') || strlen($request->security_token) < 10) {
            return back()->with('error', 'Invalid security token.');
        }

        // Find the pricing plan
        $plan = PricingPlan::findOrFail($id);

        // Validate the request data with more comprehensive rules
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^<>&\'\"]*$/',
                function ($attribute, $value, $fail) {
                    // Additional validation for potential XSS attempts
                    if (preg_match('/(script|javascript|on\w+\s*=|alert\s*\()/i', $value)) {
                        $fail('The :attribute contains potentially malicious content.');
                    }
                },
            ],
            'price' => 'required|numeric|min:0|max:100000',
            'currency' => [
                'nullable',
                'string',
                'max:10',
                'regex:/^[^<>&\'\"]*$/',
            ],
            'duration' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[^<>&\'\"]*$/',
            ],
            'btn_text' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[^<>&\'\"]*$/',
            ],
            'btn_url' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[^<>\'"]*$/',
            ],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'security_token' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Sanitize all inputs before saving
        $sanitizedData = $this->sanitizeData($request->only([
            'title',
            'price',
            'currency',
            'duration',
            'btn_text',
            'btn_url'
        ]));

        // Update pricing plan
        $plan->title = $sanitizedData['title'];
        $plan->price = $sanitizedData['price'];
        $plan->currency = $sanitizedData['currency'];
        $plan->duration = $sanitizedData['duration'];
        $plan->btn_text = $sanitizedData['btn_text'];
        $plan->btn_url = $sanitizedData['btn_url'];
        $plan->is_active = $request->has('is_active');
        $plan->is_featured = $request->has('is_featured');
        $plan->save();

        return redirect()->back()->with('success', 'تم تحديث خطة التسعير بنجاح');
    }

    /**
     * Remove the specified pricing plan from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = PricingPlan::findOrFail($id);
        $plan->delete();

        return redirect()->back()->with('success', 'تم حذف خطة التسعير بنجاح');
    }

    /**
     * Update the order of pricing plans.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        // Rate limiting: 10 attempts per minute per IP
        $ipAddress = $request->ip();
        $key = "pricing_plan_order_{$ipAddress}";

        if (RateLimiter::tooManyAttempts($key, 10)) {
            return response()->json(['error' => 'Too many attempts'], 429);
        }

        RateLimiter::hit($key, 60); // Remember for 60 seconds

        $plans = $request->input('plans', []);

        foreach ($plans as $order => $planId) {
            PricingPlan::where('id', $planId)->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Sanitize input data
     *
     * @param  array  $data
     * @return array
     */
    private function sanitizeData(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                // HTML entities encoding
                $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                // Strip potentially dangerous patterns
                $value = preg_replace([
                    '/(javascript|script|alert|onerror|onload|eval|expression)/i',
                    '/on\w+\s*=\s*["\'][^"\']*["\']/',  // Remove event handlers
                    '/javascript\s*:/i',
                    '/data\s*:/i',
                    '/vbscript\s*:/i',
                    '/\bexpression\s*\(/i'
                ], '', $value);

                // For URL fields, ensure they start with http:// or https://
                if ($key === 'btn_url' && !empty($value) && !preg_match('/^https?:\/\//i', $value)) {
                    $value = 'https://' . ltrim($value, '/');
                }
            }

            $sanitized[$key] = $value;
        }

        return $sanitized;
    }

    /**
     * Generate secure token
     *
     * @return string
     */
    public function generateSecurityToken()
    {
        $timestamp = time();
        $random = bin2hex(random_bytes(8));
        $hash = hash_hmac('sha256', $timestamp . $random, config('app.key'));
        return $timestamp . ':' . $hash;
    }
}
