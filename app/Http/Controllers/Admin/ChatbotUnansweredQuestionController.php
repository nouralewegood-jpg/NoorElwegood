<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotSetting;
use App\Models\ChatbotUnansweredQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotUnansweredQuestionController extends Controller
{
    /**
     * عرض قائمة الأسئلة غير المجاب عليها
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = ChatbotUnansweredQuestion::query()->orderBy('frequency', 'desc');

        // تصفية حسب الحالة إذا كانت محددة
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $questions = $query->paginate(15);

        return view('admin.chatbot-questions.index', compact('questions', 'status'));
    }

    /**
     * عرض نموذج إضافة إجابة للسؤال
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $question = ChatbotUnansweredQuestion::findOrFail($id);
        return view('admin.chatbot-questions.edit', compact('question'));
    }

    /**
     * حفظ إجابة للسؤال
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string|max:1000',
        ]);

        $question = ChatbotUnansweredQuestion::findOrFail($id);

        $question->update([
            'answer' => $request->input('answer'),
            'status' => 'answered',
            'answered_at' => now()
        ]);

        return redirect()->route('admin.chatbot-questions.index')
            ->with('success', 'تم حفظ الإجابة بنجاح');
    }

    /**
     * نقل سؤال وإجابة إلى إعدادات الشات بوت
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer($id)
    {
        $question = ChatbotUnansweredQuestion::findOrFail($id);

        // التحقق من وجود إجابة قبل النقل
        if (empty($question->answer) || $question->status !== 'answered') {
            return redirect()->route('admin.chatbot-questions.index')
                ->with('error', 'يجب إضافة إجابة للسؤال قبل نقله');
        }

        DB::beginTransaction();

        try {
            // نقل السؤال إلى إعدادات الشات بوت
            $setting = $question->transferToSettings();

            if ($setting) {
                DB::commit();
                return redirect()->route('admin.chatbot-questions.index')
                    ->with('success', 'تم نقل السؤال والإجابة إلى إعدادات الشات بوت بنجاح');
            } else {
                throw new \Exception('فشل في نقل السؤال إلى إعدادات الشات بوت');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.chatbot-questions.index')
                ->with('error', 'حدث خطأ أثناء نقل السؤال: ' . $e->getMessage());
        }
    }

    /**
     * نقل مجموعة من الأسئلة إلى إعدادات الشات بوت
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkTransfer(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'exists:chatbot_unanswered_questions,id'
        ]);

        $ids = $request->input('questions');
        $successCount = 0;
        $failCount = 0;

        foreach ($ids as $id) {
            $question = ChatbotUnansweredQuestion::find($id);

            if ($question && !empty($question->answer) && $question->status === 'answered') {
                DB::beginTransaction();

                try {
                    $setting = $question->transferToSettings();

                    if ($setting) {
                        DB::commit();
                        $successCount++;
                    } else {
                        DB::rollBack();
                        $failCount++;
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    $failCount++;
                }
            } else {
                $failCount++;
            }
        }

        return redirect()->route('admin.chatbot-questions.index')
            ->with('success', "تم نقل $successCount سؤال بنجاح، وفشل نقل $failCount سؤال");
    }

    /**
     * حذف سؤال
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $question = ChatbotUnansweredQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.chatbot-questions.index')
            ->with('success', 'تم حذف السؤال بنجاح');
    }
}
