<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotSynonym;
use Illuminate\Http\Request;

class ChatbotSynonymController extends Controller
{
    /**
     * عرض قائمة المرادفات
     */
    public function index()
    {
        $synonyms = ChatbotSynonym::orderBy('id', 'desc')->paginate(10);
        return view('admin.chatbot-synonyms.index', compact('synonyms'));
    }

    /**
     * عرض نموذج إضافة مرادفات جديدة
     */
    public function create()
    {
        return view('admin.chatbot-synonyms.create');
    }

    /**
     * تخزين مرادف جديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'main_word' => 'required|string|unique:chatbot_synonyms,main_word',
            'synonyms' => 'required',
            'active' => 'nullable|boolean',
        ]);

        // معالجة المرادفات - تحويل النص المفصول بفواصل إلى مصفوفة
        $synonymsArray = array_map('trim', explode(',', $request->synonyms));
        $data['synonyms'] = $synonymsArray;
        $data['active'] = $request->boolean('active');

        ChatbotSynonym::create($data);
        return redirect()->route('admin.chatbot-synonyms.index')
            ->with('success', 'تم إضافة المرادفات بنجاح.');
    }

    /**
     * عرض مرادف معين
     */
    public function show(ChatbotSynonym $chatbotSynonym)
    {
        return view('admin.chatbot-synonyms.show', compact('chatbotSynonym'));
    }

    /**
     * عرض نموذج تعديل مرادف
     */
    public function edit(ChatbotSynonym $chatbotSynonym)
    {
        return view('admin.chatbot-synonyms.edit', compact('chatbotSynonym'));
    }

    /**
     * تحديث مرادف معين
     */
    public function update(Request $request, ChatbotSynonym $chatbotSynonym)
    {
        $data = $request->validate([
            'main_word' => 'required|string|unique:chatbot_synonyms,main_word,' . $chatbotSynonym->id,
            'synonyms' => 'required',
            'active' => 'nullable|boolean',
        ]);

        // معالجة المرادفات - تحويل النص المفصول بفواصل إلى مصفوفة
        $synonymsArray = array_map('trim', explode(',', $request->synonyms));
        $data['synonyms'] = $synonymsArray;
        $data['active'] = $request->boolean('active');

        $chatbotSynonym->update($data);
        return redirect()->route('admin.chatbot-synonyms.index')
            ->with('success', 'تم تحديث المرادفات بنجاح.');
    }

    /**
     * حذف مرادف معين
     */
    public function destroy(ChatbotSynonym $chatbotSynonym)
    {
        $chatbotSynonym->delete();
        return redirect()->route('admin.chatbot-synonyms.index')
            ->with('success', 'تم حذف المرادفات بنجاح.');
    }
}
