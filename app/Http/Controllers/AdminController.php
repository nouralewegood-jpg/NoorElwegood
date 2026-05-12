<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get counts for dashboard statistics
        $productsCount = Product::count();
        $pagesCount = Page::count();
        $servicesCount = Service::count();

        return view('admin.dashboard', compact('productsCount', 'pagesCount', 'servicesCount'));
    }

    /**
     * Show the admin settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Show the admin profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update user profile information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileInfo(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        $user->save();

        return back()->with('success', 'تم تحديث البيانات الشخصية بنجاح!');
    }

    /**
     * Update user password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
        ], [
            'password.regex' => 'كلمة المرور يجب أن تحتوي على حرف كبير، حرف صغير، رقم ورمز خاص على الأقل'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // تحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }

    /**
     * Update user profile image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileImage(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // حذف الصورة القديمة إذا وجدت
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // معالجة وحفظ الصورة الجديدة
            $image = $request->file('profile_image');
            $filename = 'profile_' . time() . '.' . $image->getClientOriginalExtension();
            $path = 'profile_images/' . $filename;

            // إنشاء مجلد الصور الشخصية إذا لم يكن موجوداً
            if (!Storage::disk('public')->exists('profile_images')) {
                Storage::disk('public')->makeDirectory('profile_images');
            }

            // طريقة مباشرة لتخزين الصورة باستخدام Laravel فقط
            $image->storeAs('public', $path);

            $user->profile_image = $path;
            $user->save();

            return back()->with('success', 'تم تحديث الصورة الشخصية بنجاح!');
        } catch (\Exception $e) {
            return back()->withErrors(['profile_image' => 'حدث خطأ أثناء تحديث الصورة: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Update admin dashboard logo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDashboardLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dashboard_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // معالجة وحفظ الشعار الجديد
        $logoFile = $request->file('dashboard_logo');
        $logoFileName = 'logo.' . $logoFile->getClientOriginalExtension();

        // نسخ الشعار الأصلي كنسخة احتياطية قبل الاستبدال
        if (file_exists(public_path('assets-admin/img/brand/logo.png'))) {
            copy(
                public_path('assets-admin/img/brand/logo.png'),
                public_path('assets-admin/img/brand/logo_backup_' . date('YmdHis') . '.png')
            );
        }

        // حفظ الشعار الجديد
        $logoFile->move(public_path('assets-admin/img/brand'), $logoFileName);

        // نسخ نفس الشعار كلوجو أبيض إذا كان بتنسيق PNG
        if ($logoFile->getClientOriginalExtension() == 'png') {
            copy(
                public_path('assets-admin/img/brand/' . $logoFileName),
                public_path('assets-admin/img/brand/logo-white.png')
            );
        }

        return back()->with('success', 'تم تحديث شعار لوحة التحكم بنجاح!');
    }
}
