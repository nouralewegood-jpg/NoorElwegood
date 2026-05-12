<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsOfService;
use Illuminate\Support\Facades\Validator;

class TermsOfServiceController extends Controller
{
    /**
     * عرض صفحة إدارة شروط الخدمة
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $termsOfService = TermsOfService::where('is_active', true)
            ->latest('last_updated_at')
            ->first();

        if (!$termsOfService) {
            $termsOfService = new TermsOfService([
                'title' => 'شروط الخدمة',
                'content' => '',
                'is_active' => true,
                'last_updated_at' => now(),
            ]);
            $termsOfService->save();
        }

        return view('admin.terms-of-service.index', compact('termsOfService'));
    }

    /**
     * عرض نموذج تحرير شروط الخدمة
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $termsOfService = TermsOfService::findOrFail($id);
        return view('admin.terms-of-service.edit', compact('termsOfService'));
    }

    /**
     * تحديث شروط الخدمة في قاعدة البيانات
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $termsOfService = TermsOfService::findOrFail($id);

        $termsOfService->update([
            'title' => $request->title,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'last_updated_at' => now(),
        ]);

        return redirect()->route('admin.terms-of-service.index')
            ->with('success', 'تم تحديث شروط الخدمة بنجاح.');
    }
}
