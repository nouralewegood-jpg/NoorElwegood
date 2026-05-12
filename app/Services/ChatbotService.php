<?php

namespace App\Services;

use App\Models\ChatbotSetting;
use App\Models\ChatbotSynonym;
use App\Models\ChatbotUnansweredQuestion;
use Illuminate\Support\Facades\Cache;

class ChatbotService
{
    /**
     * قائمة المترادفات المؤقتة للكلمات والمتعلقات بهدف دعم صيغ وأساليب مختلفة للأسئلة
     */
    private $synonyms = [];

    /**
     * تهيئة الخدمة وتحميل المترادفات من قاعدة البيانات
     */
    public function __construct()
    {
        $this->loadSynonymsFromDatabase();
    }

    /**
     * تحميل المترادفات من قاعدة البيانات
     *
     * @return void
     */
    private function loadSynonymsFromDatabase()
    {
        // استخدام الكاش لتسريع الاستعلام
        $cachedSynonyms = Cache::remember('chatbot_synonyms', 60 * 60, function () {
            $dbSynonyms = ChatbotSynonym::where('active', true)->get();
            $synonymsList = [];

            foreach ($dbSynonyms as $synonym) {
                if (is_array($synonym->synonyms)) {
                    $synonymsList[$synonym->main_word] = $synonym->synonyms;
                }
            }

            return $synonymsList;
        });

        $this->synonyms = $cachedSynonyms;
    }

    /**
     * Generate a chatbot response based on input message
     * @param string $message
     * @return string
     */
    public function getResponse(string $message): string
    {
        // Load all active settings
        $settings = ChatbotSetting::where('active', true)->get();

        if ($settings->isEmpty()) {
            return 'عذراً، لا توجد إجابات متاحة حالياً.';
        }

        $messageLower = mb_strtolower(trim($message));

        // معالجة النص العربي (حذف الهمزات وتوحيد أشكال الحروف)
        $messageNormalized = $this->normalizeArabicText($messageLower);

        // توسيع البحث ليشمل المترادفات
        $expandedMessage = $this->expandWithSynonyms($messageNormalized);

        // معالجة السؤال عن العنوان (أو مرادفاته)
        foreach ($this->synonyms as $mainWord => $syns) {
            $mainNorm = $this->normalizeArabicText(mb_strtolower($mainWord));
            if (str_contains($messageNormalized, $mainNorm) || str_contains($expandedMessage, $mainNorm)) {
                $match = $this->findSettingByKeyword($mainWord, $settings);
                if ($match) {
                    // زيادة عداد التكرار للسؤال المطابق
                    $this->incrementQuestionFrequency($match);
                    return $match->value;
                }
            }
            foreach ($syns as $syn) {
                $synNorm = $this->normalizeArabicText(mb_strtolower($syn));
                if (str_contains($messageNormalized, $synNorm) || str_contains($expandedMessage, $synNorm)) {
                    $match = $this->findSettingByKeyword($mainWord, $settings);
                    if ($match) {
                        // زيادة عداد التكرار للسؤال المطابق
                        $this->incrementQuestionFrequency($match);
                        return $match->value;
                    }
                }
            }
        }

        // التحقق من الإدخال إذا كان كلمة واحدة فقط
        $isSingleWord = !str_contains($messageNormalized, ' ');

        // طريقة 1: البحث المباشر (إذا وجد تطابق مباشر)
        foreach ($settings as $setting) {
            $key = mb_strtolower($setting->key);
            $keyNormalized = $this->normalizeArabicText($key);

            if (str_contains($messageNormalized, $keyNormalized) || str_contains($expandedMessage, $keyNormalized)) {
                // زيادة عداد التكرار للسؤال المطابق
                $this->incrementQuestionFrequency($setting);
                return $setting->value;
            }
        }

        // طريقة 2: إذا كانت كلمة واحدة فقط، نبحث عن الكلمات الرئيسية المطابقة
        if ($isSingleWord && mb_strlen($messageNormalized) >= 2) {
            $matchBySingleWord = $this->findMatchBySingleWord($messageNormalized, $settings);

            if ($matchBySingleWord) {
                // زيادة عداد التكرار للسؤال المطابق
                $this->incrementQuestionFrequency($matchBySingleWord);
                return $matchBySingleWord->value;
            }

            // إذا لم نجد مطابقة، نجرب البحث باستخدام المترادفات
            foreach ($this->getSynonymsFor($messageNormalized) as $synonym) {
                $matchBySynonym = $this->findMatchBySingleWord($synonym, $settings);
                if ($matchBySynonym) {
                    // زيادة عداد التكرار للسؤال المطابق
                    $this->incrementQuestionFrequency($matchBySynonym);
                    return $matchBySynonym->value;
                }
            }
        }

        // طريقة 3: البحث عن أقرب سؤال باستخدام مسافة ليفنشتاين
        $bestMatch = $this->findClosestMatch($messageNormalized, $settings);

        if ($bestMatch) {
            // زيادة عداد التكرار للسؤال المطابق
            $this->incrementQuestionFrequency($bestMatch);
            return $bestMatch->value;
        }

        // محاولة أخيرة باستخدام الرسالة الموسعة بالمترادفات
        $bestMatchWithSynonyms = $this->findClosestMatch($expandedMessage, $settings);

        if ($bestMatchWithSynonyms) {
            // زيادة عداد التكرار للسؤال المطابق
            $this->incrementQuestionFrequency($bestMatchWithSynonyms);
            return $bestMatchWithSynonyms->value;
        }

        // تسجيل السؤال الذي لم يتم العثور له على إجابة
        $this->recordUnansweredQuestion($message);

        // Default fallback
        return 'عذراً، لم أفهم سؤالك جيداً. يرجى إعادة صياغة السؤال.';
    }

    /**
     * زيادة عداد التكرار للسؤال المطابق
     *
     * @param ChatbotSetting $setting الإعداد الذي تم مطابقته
     * @return void
     */
    private function incrementQuestionFrequency(ChatbotSetting $setting): void
    {
        $setting->increment('frequency');
    }

    /**
     * تسجيل سؤال جديد لم يتم العثور له على إجابة في الشات بوت
     *
     * @param string $question السؤال الذي لم تتم الإجابة عليه
     */
    private function recordUnansweredQuestion(string $question): void
    {
        if (empty(trim($question))) {
            return;
        }

        // تطبيع السؤال الجديد (توحيد الحروف وإزالة التشكيل وغيرها)
        $normalizedQuestion = $this->normalizeArabicText(mb_strtolower(trim($question)));

        // الحصول على جميع الأسئلة غير المجابة
        $existingQuestions = ChatbotUnansweredQuestion::all();

        // البحث عن الأسئلة المشابهة
        $similarQuestion = null;
        $highestSimilarity = 0;
        $similarityThreshold = 0.75; // عتبة التشابه للاعتبار أن السؤالين متشابهين

        foreach ($existingQuestions as $existingQuestion) {
            // تطبيع السؤال الموجود
            $normalizedExistingQuestion = $this->normalizeArabicText(mb_strtolower(trim($existingQuestion->question)));

            // حساب درجة التشابه بين السؤالين
            $similarity = $this->calculateQuestionSimilarity($normalizedQuestion, $normalizedExistingQuestion);

            // إذا وجدنا سؤال مشابه بدرجة كافية
            if ($similarity > $similarityThreshold && $similarity > $highestSimilarity) {
                $similarQuestion = $existingQuestion;
                $highestSimilarity = $similarity;
            }
        }

        // تحديث العداد إذا وجدنا سؤال مشابه
        if ($similarQuestion) {
            // تحديث عداد وتاريخ السؤال المشابه
            $similarQuestion->update([
                'frequency' => $similarQuestion->frequency + 1,
                'last_asked_at' => now()
            ]);
        } else {
            // إضافة سؤال جديد إذا لم نجد سؤال مشابه
            ChatbotUnansweredQuestion::create([
                'question' => $question,
                'status' => 'pending'
            ]);
        }
    }

    /**
     * حساب درجة التشابه بين سؤالين
     *
     * @param string $question1 السؤال الأول بعد التطبيع
     * @param string $question2 السؤال الثاني بعد التطبيع
     * @return float درجة التشابه (0 إلى 1)
     */
    private function calculateQuestionSimilarity(string $question1, string $question2): float
    {
        // 1. تطابق كامل
        if ($question1 === $question2) {
            return 1.0;
        }

        // 2. الاحتواء (إذا كان أحد السؤالين يحتوي الآخر)
        if (str_contains($question1, $question2) || str_contains($question2, $question1)) {
            // حساب نسبة التداخل
            $shorterLength = min(mb_strlen($question1), mb_strlen($question2));
            $longerLength = max(mb_strlen($question1), mb_strlen($question2));
            return 0.8 + (($shorterLength / $longerLength) * 0.2); // يعطي قيمة من 0.8 إلى 1.0
        }

        // 3. مقارنة الكلمات
        $words1 = explode(' ', $question1);
        $words2 = explode(' ', $question2);

        // حذف الكلمات القصيرة جداً (أقل من 3 أحرف)
        $words1 = array_filter($words1, function ($word) {
            return mb_strlen($word) > 2;
        });

        $words2 = array_filter($words2, function ($word) {
            return mb_strlen($word) > 2;
        });

        // إذا لم يبقى كلمات بعد التصفية
        if (count($words1) == 0 || count($words2) == 0) {
            return 0;
        }

        // حساب الكلمات المشتركة
        $commonWords = array_intersect($words1, $words2);
        $commonWordsCount = count($commonWords);

        // حساب نسبة الكلمات المشتركة
        $wordSimilarity = (2 * $commonWordsCount) / (count($words1) + count($words2));

        // 4. مسافة ليفنشتاين للسؤال الكامل
        $maxLength = max(mb_strlen($question1), mb_strlen($question2));
        if ($maxLength > 0) {
            $levenshteinDistance = levenshtein($question1, $question2);
            $textSimilarity = 1 - ($levenshteinDistance / $maxLength);
        } else {
            $textSimilarity = 0;
        }

        // المعادلة النهائية للتشابه - إعطاء وزن أكبر للكلمات المشتركة
        return ($wordSimilarity * 0.7) + ($textSimilarity * 0.3);
    }

    /**
     * الحصول على قائمة بالمترادفات لكلمة معينة
     *
     * @param string $word الكلمة المراد البحث عن مترادفاتها
     * @return array قائمة المترادفات
     */
    private function getSynonymsFor(string $word): array
    {
        foreach ($this->synonyms as $mainWord => $synonymsList) {
            // إذا كانت الكلمة هي الكلمة الرئيسية
            if (str_contains($word, $mainWord)) {
                return $synonymsList;
            }

            // إذا كانت الكلمة من ضمن المترادفات
            if (in_array($word, $synonymsList)) {
                $allSynonyms = array_merge([$mainWord], $synonymsList);
                // إزالة الكلمة نفسها من القائمة
                return array_diff($allSynonyms, [$word]);
            }
        }

        return [];
    }

    /**
     * توسيع النص ليشمل المترادفات المحتملة
     *
     * @param string $text النص المراد توسيعه
     * @return string النص بعد التوسيع
     */
    private function expandWithSynonyms(string $text): string
    {
        $words = explode(' ', $text);
        $expandedText = $text;

        foreach ($words as $word) {
            if (mb_strlen($word) < 2) continue; // تجاهل الكلمات القصيرة جدًا

            $synonyms = $this->getSynonymsFor($word);
            if (!empty($synonyms)) {
                // إضافة المترادفات إلى النص الأصلي مفصولة بمسافات
                $expandedText .= ' ' . implode(' ', $synonyms);
            }
        }

        return $expandedText;
    }

    /**
     * العثور على مطابقة باستخدام كلمة واحدة
     *
     * @param string $word كلمة المستخدم
     * @param \Illuminate\Support\Collection $settings إعدادات الشات بوت
     * @return ChatbotSetting|null أفضل مطابقة أو قيمة فارغة إذا لم يتم العثور على مطابقة
     */
    private function findMatchBySingleWord(string $word, $settings)
    {
        $bestMatch = null;
        $bestScore = 0.45; // درجة التشابه الافتراضية المطلوبة (أقل من الطرق الأخرى لزيادة احتمالية المطابقة)

        foreach ($settings as $setting) {
            $key = mb_strtolower($setting->key);
            $keyNormalized = $this->normalizeArabicText($key);
            $keyWords = explode(' ', $keyNormalized);

            // البحث عن مطابقة مباشرة للكلمة الفردية مع كلمات المفتاح
            foreach ($keyWords as $keyWord) {
                if (mb_strlen($keyWord) <= 2) continue; // تجاهل الكلمات القصيرة جدًا

                // حساب درجة التشابه بين كلمة المستخدم وكلمة المفتاح
                $similarity = $this->calculateWordSimilarity($word, $keyWord);

                // إذا كانت هذه الكلمة مطابقة بدرجة كافية وهي الأفضل حتى الآن
                if ($similarity > $bestScore) {
                    $bestScore = $similarity;
                    $bestMatch = $setting;

                    // إذا كانت المطابقة ممتازة (فوق 80%)، لا داعي للاستمرار في البحث
                    if ($similarity > 0.8) {
                        return $bestMatch;
                    }
                }
            }
        }

        return $bestMatch;
    }

    /**
     * Find the closest matching question using text similarity algorithms
     *
     * @param string $message User's message
     * @param \Illuminate\Support\Collection $settings Collection of chatbot settings
     * @return ChatbotSetting|null The closest matching setting or null if no match found
     */
    private function findClosestMatch(string $message, $settings)
    {
        $bestMatch = null;
        $bestScore = -1;
        $threshold = 0.5; // خفض الحد الأدنى للتشابه لزيادة احتمال العثور على مطابقات

        // للكلمات الفردية، نستخدم عتبة أقل للتشابه
        $wordCount = count(explode(' ', $message));
        if ($wordCount <= 2) {
            $threshold = 0.45;
        }

        foreach ($settings as $setting) {
            $key = mb_strtolower($setting->key);
            $keyNormalized = $this->normalizeArabicText($key);

            // حساب التشابه باستخدام عدة خوارزميات
            $score = $this->calculateSimilarity($message, $keyNormalized);

            // تحديث أفضل تطابق إذا كان أعلى من السابق
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $setting;
            }
        }

        // إرجاع أفضل تطابق فقط إذا كان يتجاوز الحد الأدنى للتشابه
        return ($bestScore >= $threshold) ? $bestMatch : null;
    }

    /**
     * حساب درجة التشابه بين كلمتين
     *
     * @param string $word1 الكلمة الأولى
     * @param string $word2 الكلمة الثانية
     * @return float درجة التشابه (0 إلى 1)
     */
    private function calculateWordSimilarity(string $word1, string $word2): float
    {
        // إذا كانت إحدى الكلمتين فارغة، فلا يوجد تشابه
        if (mb_strlen($word1) === 0 || mb_strlen($word2) === 0) {
            return 0;
        }

        // التطابق الكامل
        if ($word1 === $word2) {
            return 1.0;
        }

        // إذا كانت إحدى الكلمتين محتواة في الأخرى
        if (str_contains($word1, $word2) || str_contains($word2, $word1)) {
            // حساب نسبة الاحتواء (أطول كلمة / أقصر كلمة) للحصول على درجة دقيقة
            $ratio = min(mb_strlen($word1), mb_strlen($word2)) / max(mb_strlen($word1), mb_strlen($word2));
            return 0.7 + ($ratio * 0.3); // قيمة بين 0.7 و 1.0 حسب نسبة الاحتواء
        }

        // حساب مسافة ليفنشتاين
        $maxLength = max(mb_strlen($word1), mb_strlen($word2));
        $levenshteinDistance = levenshtein($word1, $word2);

        // تحويل المسافة إلى نسبة تشابه (من 0 إلى 1)
        $similarityScore = 1 - ($levenshteinDistance / $maxLength);

        // تعزيز التشابه إذا كانت بداية الكلمتين متشابهة (مهم في الجذور العربية)
        $prefixLength = 0;
        $maxPrefixCheck = min(mb_strlen($word1), mb_strlen($word2), 5);  // نتحقق من أول 5 أحرف كحد أقصى

        for ($i = 0; $i < $maxPrefixCheck; $i++) {
            if (mb_substr($word1, 0, $i + 1) === mb_substr($word2, 0, $i + 1)) {
                $prefixLength = $i + 1;
            } else {
                break;
            }
        }

        // إذا كانت بداية الكلمتين متشابهة، نعزز درجة التشابه
        if ($prefixLength >= 2) {
            $prefixBoost = $prefixLength / $maxLength * 0.3; // تعزيز بنسبة تصل إلى 30%
            $similarityScore = $similarityScore * 0.7 + $prefixBoost;
        }

        return $similarityScore;
    }

    /**
     * معالجة وتطبيع النص العربي لتسهيل المقارنة
     *
     * @param string $text النص المراد معالجته
     * @return string النص بعد المعالجة
     */
    private function normalizeArabicText(string $text): string
    {
        // تحويل الهمزات المختلفة إلى شكل موحد
        $text = str_replace(['أ', 'إ', 'آ'], 'ا', $text);

        // توحيد التاء المربوطة والهاء
        $text = str_replace(['ة'], 'ه', $text);

        // توحيد أشكال الألف المقصورة والياء
        $text = str_replace(['ى'], 'ي', $text);

        // إزالة التشكيل (الفتحة، الضمة، الكسرة، إلخ)
        $text = preg_replace('/[\x{064B}-\x{0652}]/u', '', $text);

        // إزالة علامات الترقيم والأرقام
        $text = preg_replace('/[0-9\.\,\"\'\?\!\(\)\[\]\{\}\:\;\_\+\=\-\*\/\\\\]/u', ' ', $text);

        // تقليص المسافات المتعددة إلى مسافة واحدة
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    /**
     * Calculate similarity score between two strings
     *
     * @param string $str1 First string
     * @param string $str2 Second string
     * @return float Similarity score (0 to 1)
     */
    private function calculateSimilarity(string $str1, string $str2): float
    {
        // الاختصارات والكلمات القصيرة جداً قد لا تعمل بشكل جيد مع مسافة ليفنشتاين
        // لذا نستخدم عدة أساليب للمقارنة

        // 1. تطابق كامل
        if ($str1 === $str2) {
            return 1.0;
        }

        // 2. الاحتواء
        if (str_contains($str1, $str2) || str_contains($str2, $str1)) {
            // رفع درجة الاحتواء لتحسين النتائج
            $containmentScore = 0.85;
            return $containmentScore;
        }

        // 3. مقارنة الكلمات الفردية
        $words1 = explode(' ', $str1);
        $words2 = explode(' ', $str2);

        // الكلمات المشتركة
        $commonWords = array_intersect($words1, $words2);
        $wordsSimilarity = count($commonWords) / max(count($words1), count($words2));

        // 4. مقارنة الكلمات باستخدام مسافة ليفنشتاين
        $wordMatchCount = 0;
        $totalWords = count($words1);

        foreach ($words1 as $word1) {
            if (mb_strlen($word1) <= 2) continue; // تجاهل الكلمات القصيرة جدًا

            $bestWordScore = 0;
            foreach ($words2 as $word2) {
                if (mb_strlen($word2) <= 2) continue;

                $wordSimilarity = 0;

                // التطابق الكامل للكلمة
                if ($word1 === $word2) {
                    $wordSimilarity = 1.0;
                } else {
                    // مقارنة الكلمات باستخدام مسافة ليفنشتاين
                    $maxWordLength = max(mb_strlen($word1), mb_strlen($word2));
                    if ($maxWordLength > 0) {
                        $levenshteinDistance = levenshtein($word1, $word2);
                        $wordSimilarity = 1 - ($levenshteinDistance / $maxWordLength);
                    }
                }

                $bestWordScore = max($bestWordScore, $wordSimilarity);
            }

            if ($bestWordScore > 0.7) { // اعتبار الكلمة متطابقة إذا كان التشابه أكبر من 70%
                $wordMatchCount++;
            }
        }

        $wordAccuracyScore = $totalWords > 0 ? $wordMatchCount / $totalWords : 0;

        // 5. حساب مسافة ليفنشتاين للنص الكامل
        $maxLength = max(mb_strlen($str1), mb_strlen($str2));
        if ($maxLength === 0) {
            return 0;
        }

        // حساب مسافة ليفنشتاين (عدد التعديلات المطلوبة لتحويل نص إلى آخر)
        $levenshteinDistance = levenshtein($str1, $str2);

        // تحويل المسافة إلى نسبة تشابه (من 0 إلى 1)
        $textSimilarityScore = 1 - ($levenshteinDistance / $maxLength);

        // تعديل المعادلة النهائية للتشابه لإعطاء وزن أكبر لتشابه الكلمات الفردية
        // عندما يكون النص قصير (كلمة واحدة أو كلمتين)
        $words1Count = count(explode(' ', $str1));
        if ($words1Count <= 2) {
            return max(
                $textSimilarityScore * 0.5,  // زيادة وزن تشابه النص الكلي
                $wordsSimilarity * 0.25,
                $wordAccuracyScore * 0.25
            );
        }

        // المعادلة الأصلية للنصوص الأطول
        return max(
            $textSimilarityScore * 0.4,
            $wordsSimilarity * 0.3,
            $wordAccuracyScore * 0.3
        );
    }

    /**
     * العثور على إعدادات الشات بوت بناءً على الكلمة الرئيسية
     *
     * @param string $keyword الكلمة الرئيسية
     * @param \Illuminate\Support\Collection $settings إعدادات الشات بوت
     * @return ChatbotSetting|null أفضل مطابقة أو قيمة فارغة إذا لم يتم العثور على مطابقة
     */
    private function findSettingByKeyword(string $keyword, $settings)
    {
        foreach ($settings as $setting) {
            $key = mb_strtolower($setting->key);
            $keyNormalized = $this->normalizeArabicText($key);

            if (str_contains($keyNormalized, $keyword)) {
                return $setting;
            }
        }

        return null;
    }
}
