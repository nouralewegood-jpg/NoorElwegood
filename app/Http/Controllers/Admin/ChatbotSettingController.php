<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotSetting;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\Validator;

class ChatbotSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // استرجاع معايير البحث والتصنيف
        $search = $request->input('search');
        $sortField = $request->input('sort', 'frequency');  // التصنيف الافتراضي حسب عدد مرات السؤال
        $sortDirection = $request->input('direction', 'desc');  // الترتيب الافتراضي تنازلي

        // إنشاء الاستعلام الأساسي
        $query = ChatbotSetting::query();

        // تطبيق معايير البحث إذا وجدت
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                    ->orWhere('value', 'like', "%{$search}%");
            });
        }

        // تطبيق معايير التصنيف
        $query->orderBy($sortField, $sortDirection);

        // جلب النتائج مع التصفيح
        $settings = $query->paginate(10)->withQueryString();

        return view('admin.chatbot-settings.index', compact('settings', 'search', 'sortField', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.chatbot-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:chatbot_settings,key',
            'value' => 'required|string',
            'type' => 'required|string',
            'active' => 'nullable|boolean',
        ]);
        $data['active'] = $request->boolean('active');
        $data['frequency'] = 0;  // تعيين القيمة الافتراضية لعدد مرات السؤال

        ChatbotSetting::create($data);
        return redirect()->route('admin.chatbot-settings.index')
            ->with('success', 'تم إنشاء الإعداد بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChatbotSetting $chatbotSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatbotSetting $chatbotSetting)
    {
        return view('admin.chatbot-settings.edit', compact('chatbotSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatbotSetting $chatbotSetting)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:chatbot_settings,key,' . $chatbotSetting->id,
            'value' => 'required|string',
            'type' => 'required|string',
            'active' => 'nullable|boolean',
            'frequency' => 'nullable|integer',
        ]);
        $data['active'] = $request->boolean('active');

        // إذا تم توفير قيمة التكرار، استخدمها، وإلا احتفظ بالقيمة القديمة
        if (!isset($data['frequency'])) {
            $data['frequency'] = $chatbotSetting->frequency;
        }

        $chatbotSetting->update($data);
        return redirect()->route('admin.chatbot-settings.index')
            ->with('success', 'تم تحديث الإعداد بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatbotSetting $chatbotSetting)
    {
        $chatbotSetting->delete();
        return redirect()->route('admin.chatbot-settings.index')
            ->with('success', 'تم حذف الإعداد بنجاح.');
    }

    /**
     * تصدير تقرير بأسئلة الشات بوت وعدد مرات طرحها
     */
    public function export(Request $request)
    {
        // استرجاع معايير البحث والتصنيف
        $search = $request->input('search');
        $sortField = $request->input('sort', 'frequency');
        $sortDirection = $request->input('direction', 'desc');

        // إنشاء الاستعلام الأساسي
        $query = ChatbotSetting::query();

        // تطبيق معايير البحث إذا وجدت
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                    ->orWhere('value', 'like', "%{$search}%");
            });
        }

        // تطبيق معايير التصنيف
        $query->orderBy($sortField, $sortDirection);

        // جلب النتائج
        $settings = $query->get();

        // إنشاء ملف Excel جديد
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ضبط اتجاه الورقة للتوافق مع اللغة العربية (من اليمين إلى اليسار)
        $sheet->setRightToLeft(true);

        // إعداد العناوين
        $sheet->setCellValue('A1', 'السؤال');
        $sheet->setCellValue('B1', 'الإجابة');
        $sheet->setCellValue('C1', 'عدد مرات السؤال');
        $sheet->setCellValue('D1', 'نوع المحتوى');
        $sheet->setCellValue('E1', 'الحالة');

        // تنسيق خلايا العنوان
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
        ];

        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // إضافة البيانات
        $row = 2;
        foreach ($settings as $setting) {
            $sheet->setCellValue('A' . $row, $setting->key);
            $sheet->setCellValue('B' . $row, $setting->value);
            $sheet->setCellValue('C' . $row, $setting->frequency);
            $sheet->setCellValue('D' . $row, $setting->type);
            $sheet->setCellValue('E' . $row, $setting->active ? 'مفعل' : 'غير مفعل');

            // تطبيق تنسيق الخلايا للصفوف
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);

            $row++;
        }

        // ضبط عرض الأعمدة تلقائياً
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // إنشاء ملف التقرير
        $writer = new Xlsx($spreadsheet);
        $filename = 'chatbot_questions_report_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = storage_path('app/public/' . $filename);

        // حفظ الملف
        $writer->save($filepath);

        // تنزيل الملف
        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ])->deleteFileAfterSend(true);
    }

    /**
     * عرض صفحة استيراد الأسئلة من ملف إكسل
     */
    public function showImport()
    {
        return view('admin.chatbot-settings.import');
    }

    /**
     * استيراد الأسئلة والأجوبة من ملف إكسل
     */
    public function import(Request $request)
    {
        // التحقق من الملف
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB max
        ], [
            'excel_file.required' => 'يرجى اختيار ملف إكسل',
            'excel_file.file' => 'يجب أن يكون الملف المرفوع ملف إكسل',
            'excel_file.mimes' => 'يجب أن يكون الملف بصيغة Excel (.xlsx, .xls)',
            'excel_file.max' => 'الحد الأقصى لحجم الملف هو 10 ميجابايت',
        ]);

        try {
            $file = $request->file('excel_file');
            $reader = new XlsxReader();
            $spreadsheet = $reader->load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // تجاهل صف العناوين
            $dataRows = array_slice($rows, 1);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            // معالجة كل صف
            foreach ($dataRows as $index => $row) {
                // المؤشر الحقيقي (مع إضافة 2 للصف لأن الصفوف في Excel تبدأ من 1 وهناك صف عناوين)
                $rowIndex = $index + 2;

                // تخطي الصفوف الفارغة
                if (empty($row[0]) && empty($row[1])) {
                    continue;
                }

                // التحقق من وجود السؤال والجواب
                if (empty($row[0])) {
                    $errors[] = "الصف {$rowIndex}: حقل السؤال مطلوب";
                    $errorCount++;
                    continue;
                }

                if (empty($row[1])) {
                    $errors[] = "الصف {$rowIndex}: حقل الإجابة مطلوب";
                    $errorCount++;
                    continue;
                }

                $key = trim($row[0]);
                $value = trim($row[1]);
                $type = !empty($row[2]) ? trim($row[2]) : 'text';
                $active = isset($row[3]) ? (bool) $row[3] : true;
                $frequency = isset($row[4]) && is_numeric($row[4]) ? (int) $row[4] : 0;

                // التحقق من عدم تكرار السؤال
                $existingSetting = ChatbotSetting::where('key', $key)->first();

                if ($existingSetting) {
                    // تحديث الإعداد الموجود
                    $existingSetting->update([
                        'value' => $value,
                        'type' => $type,
                        'active' => $active,
                        'frequency' => $frequency,
                    ]);
                } else {
                    // إنشاء إعداد جديد
                    ChatbotSetting::create([
                        'key' => $key,
                        'value' => $value,
                        'type' => $type,
                        'active' => $active,
                        'frequency' => $frequency,
                    ]);
                }

                $successCount++;
            }

            // إرجاع رسالة نجاح مع إحصائيات
            $message = "تم استيراد البيانات بنجاح. {$successCount} سؤال تم استيراده.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} سطر به أخطاء.";
            }

            return redirect()->route('admin.chatbot-settings.index')
                ->with('success', $message)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * تنزيل نموذج لملف الاستيراد
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ضبط اتجاه الورقة للتوافق مع اللغة العربية (من اليمين إلى اليسار)
        $sheet->setRightToLeft(true);

        // إضافة العناوين
        $sheet->setCellValue('A1', 'السؤال');
        $sheet->setCellValue('B1', 'الإجابة');
        $sheet->setCellValue('C1', 'النوع (text أو html)');
        $sheet->setCellValue('D1', 'مفعل (1 أو 0)');
        $sheet->setCellValue('E1', 'عدد مرات السؤال');

        // تنسيق العناوين
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
        ];

        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // إضافة بعض الأمثلة للتوضيح
        $sheet->setCellValue('A2', 'كيف يمكنني التواصل معكم؟');
        $sheet->setCellValue('B2', 'يمكنك التواصل معنا عبر البريد الإلكتروني info@example.com أو رقم الهاتف 1234567890');
        $sheet->setCellValue('C2', 'text');
        $sheet->setCellValue('D2', '1');
        $sheet->setCellValue('E2', '0');

        $sheet->setCellValue('A3', 'ما هي خدماتكم؟');
        $sheet->setCellValue('B3', 'نقدم خدمات تطوير المواقع الإلكترونية وتطبيقات الهاتف والتسويق الرقمي');
        $sheet->setCellValue('C3', 'text');
        $sheet->setCellValue('D3', '1');
        $sheet->setCellValue('E3', '0');

        // ضبط عرض الأعمدة تلقائياً
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // إنشاء الملف
        $writer = new Xlsx($spreadsheet);
        $filename = 'chatbot_settings_template.xlsx';
        $filepath = storage_path('app/public/' . $filename);

        // حفظ الملف
        $writer->save($filepath);

        // تنزيل الملف
        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ])->deleteFileAfterSend(true);
    }
}
