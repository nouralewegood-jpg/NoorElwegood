<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends Controller
{
    /**
     * Mostrar la vista de gestión de políticas de privacidad
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privacyPolicy = PrivacyPolicy::where('is_active', true)
            ->latest('last_updated_at')
            ->first();

        if (!$privacyPolicy) {
            $privacyPolicy = new PrivacyPolicy([
                'title' => 'سياسة الخصوصية',
                'content' => '',
                'is_active' => true,
                'last_updated_at' => now(),
            ]);
            $privacyPolicy->save();
        }

        return view('admin.privacy-policy.index', compact('privacyPolicy'));
    }

    /**
     * Mostrar el formulario para editar la política de privacidad
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        return view('admin.privacy-policy.edit', compact('privacyPolicy'));
    }

    /**
     * Actualizar la política de privacidad en la base de datos
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

        $privacyPolicy = PrivacyPolicy::findOrFail($id);

        $privacyPolicy->update([
            'title' => $request->title,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'last_updated_at' => now(),
        ]);

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'تم تحديث سياسة الخصوصية بنجاح.');
    }
}
