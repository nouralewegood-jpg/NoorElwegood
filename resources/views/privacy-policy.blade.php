@extends('layouts.master')

@section('css')
    <style>
        /* تنسيقات سياسة الخصوصية */
        .privacy-policy {
            padding: 60px 0;
        }

        .privacy-policy h1 {
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }

        .privacy-policy h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .privacy-policy h2,
        .privacy-policy h3 {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .privacy-policy p {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .privacy-policy ul {
            margin-bottom: 25px;
            padding-right: 20px;
        }

        .privacy-policy ul li {
            margin-bottom: 10px;
            position: relative;
        }

        .privacy-policy ul li:before {
            content: "\f054";
            font-family: "bootstrap-icons";
            position: absolute;
            right: -20px;
            color: var(--primary-color);
        }

        .privacy-policy .updated-date {
            font-style: italic;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .privacy-policy .section-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('content')
    <main class="main">
        <!-- Page Title Section -->
        <section class="page-title light-background">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>{{ $privacyPolicy->title }}</h1>
                        <nav class="breadcrumb-nav">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active">{{ $privacyPolicy->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Privacy Policy Content -->
        <section class="privacy-policy section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="updated-date">
                            آخر تحديث:
                            @if ($privacyPolicy->last_updated_at && is_object($privacyPolicy->last_updated_at))
                                {{ $privacyPolicy->last_updated_at->format('d/m/Y') }}
                            @elseif($privacyPolicy->last_updated_at)
                                {{ date('d/m/Y', strtotime($privacyPolicy->last_updated_at)) }}
                            @else
                                {{ date('d/m/Y') }}
                            @endif
                        </div>

                        <div class="privacy-content">
                            {!! $privacyPolicy->content !!}
                        </div>

                        @if (!$privacyPolicy->content)
                            <!-- محتوى افتراضي في حالة عدم وجود محتوى في قاعدة البيانات -->
                            <div class="section-box">
                                <h2>مقدمة</h2>
                                <p>نحن في [اسم الشركة] نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه
                                    كيفية جمع واستخدام وحماية أي معلومات تقدمها عند استخدام موقعنا الإلكتروني أو خدماتنا.
                                </p>
                                <p>الرجاء قراءة سياسة الخصوصية التالية بعناية لفهم وجهات نظرنا وممارساتنا فيما يتعلق
                                    ببياناتك الشخصية وكيفية معالجتها.</p>
                            </div>

                            <div class="section-box">
                                <h2>المعلومات التي نجمعها</h2>
                                <p>قد نقوم بجمع المعلومات التالية:</p>
                                <ul>
                                    <li>الاسم ومعلومات الاتصال بما في ذلك عنوان البريد الإلكتروني ورقم الهاتف</li>
                                    <li>المعلومات الديموغرافية مثل الرمز البريدي والتفضيلات والاهتمامات</li>
                                    <li>معلومات أخرى ذات صلة لاستطلاعات العملاء و/أو العروض</li>
                                    <li>بيانات سجل الزوار التي يتم جمعها تلقائياً أثناء زيارتك لموقعنا</li>
                                </ul>
                            </div>

                            <div class="section-box">
                                <h2>كيفية استخدام المعلومات</h2>
                                <p>نحتاج إلى هذه المعلومات لفهم احتياجاتك وتقديم خدمة أفضل، وبشكل خاص للأسباب التالية:</p>
                                <ul>
                                    <li>الاحتفاظ بسجلات داخلية</li>
                                    <li>تحسين منتجاتنا وخدماتنا</li>
                                    <li>إرسال رسائل ترويجية حول منتجات أو خدمات جديدة، أو معلومات أخرى نعتقد أنها قد تهمك
                                    </li>
                                    <li>الاتصال بك لأغراض أبحاث السوق</li>
                                </ul>
                            </div>

                            <div class="section-box">
                                <h2>الأمان</h2>
                                <p>نحن ملتزمون بضمان أمان معلوماتك. لمنع الوصول غير المصرح به أو الكشف عنها، وضعنا إجراءات
                                    مادية وإلكترونية وإدارية مناسبة لحماية المعلومات التي نجمعها عبر الإنترنت.</p>
                            </div>

                            <div class="section-box">
                                <h2>ملفات تعريف الارتباط (Cookies)</h2>
                                <p>ملف تعريف الارتباط هو ملف صغير يطلب الإذن ليتم وضعه على القرص الصلب لجهاز الكمبيوتر الخاص
                                    بك. بمجرد موافقتك، تتم إضافة الملف ويساعد هذا الملف في تحليل حركة المرور على الويب أو
                                    يتيح لك معرفة متى قمت بزيارة موقع معين.</p>
                                <p>تسمح لنا ملفات تعريف الارتباط بتحليل البيانات حول حركة مرور صفحة الويب ولتحسين موقعنا من
                                    أجل تخصيصه وفقاً لاحتياجات العميل. نستخدم هذه المعلومات لأغراض التحليل الإحصائي فقط،
                                    وبعد ذلك يتم إزالة البيانات من النظام.</p>
                            </div>

                            <div class="section-box">
                                <h2>الروابط لمواقع الويب الأخرى</h2>
                                <p>قد يحتوي موقعنا على روابط لمواقع أخرى مثيرة للاهتمام. ومع ذلك، بمجرد استخدامك لهذه
                                    الروابط لمغادرة موقعنا، يجب أن تلاحظ أننا لا نملك أي سيطرة على موقع الويب الآخر. لذلك،
                                    لا يمكننا أن نكون مسؤولين عن حماية وخصوصية أي معلومات تقدمها أثناء زيارة هذه المواقع ولا
                                    تغطيها سياسة خصوصية هذه.</p>
                            </div>

                            <div class="section-box">
                                <h2>التحكم في معلوماتك الشخصية</h2>
                                <p>يمكنك اختيار تقييد جمع أو استخدام معلوماتك الشخصية بالطرق التالية:</p>
                                <ul>
                                    <li>عندما يُطلب منك ملء نموذج على الموقع، ابحث عن المربع الذي يمكنك النقر عليه للإشارة
                                        إلى أنك لا تريد استخدام المعلومات لأغراض التسويق المباشر</li>
                                    <li>إذا كنت قد وافقت مسبقاً على استخدام معلوماتك الشخصية للتسويق المباشر، يمكنك تغيير
                                        رأيك في أي وقت عن طريق الاتصال بنا</li>
                                </ul>
                            </div>

                            <div class="section-box">
                                <h2>الاتصال بنا</h2>
                                <p>إذا كانت لديك أي أسئلة حول سياسة الخصوصية هذه أو كيفية معالجتنا لبياناتك الشخصية، يرجى
                                    الاتصال بنا:</p>
                                <ul>
                                    <li>عبر البريد الإلكتروني: info@example.com</li>
                                    <li>عبر الهاتف: +123456789</li>
                                    <li>أو عبر كتابة رسالة لنا على عنواننا: [عنوان الشركة]</li>
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تمييز روابط السياسة الخصوصية في شريط التنقل
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === "{{ route('privacy.policy') }}") {
                    link.classList.add('active');
                }
            });
        });
    </script>
@endsection
