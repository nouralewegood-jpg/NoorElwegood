@extends('layouts.master')

@section('css')
    <style>
        /* تنسيقات شروط الخدمة */
        .terms-of-service {
            padding: 60px 0;
        }

        .terms-of-service h1 {
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }

        .terms-of-service h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .terms-of-service h2,
        .terms-of-service h3 {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .terms-of-service p {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .terms-of-service ul {
            margin-bottom: 25px;
            padding-right: 20px;
        }

        .terms-of-service ul li {
            margin-bottom: 10px;
            position: relative;
        }

        .terms-of-service ul li:before {
            content: "\f054";
            font-family: "bootstrap-icons";
            position: absolute;
            right: -20px;
            color: var(--primary-color);
        }

        .terms-of-service .updated-date {
            font-style: italic;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .terms-of-service .section-box {
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
                        <h1>{{ $termsOfService->title }}</h1>
                        <nav class="breadcrumb-nav">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active">{{ $termsOfService->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Terms of Service Content -->
        <section class="terms-of-service section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="updated-date">
                            آخر تحديث:
                            @if ($termsOfService->last_updated_at && is_object($termsOfService->last_updated_at))
                                {{ $termsOfService->last_updated_at->format('d/m/Y') }}
                            @elseif($termsOfService->last_updated_at)
                                {{ date('d/m/Y', strtotime($termsOfService->last_updated_at)) }}
                            @else
                                {{ date('d/m/Y') }}
                            @endif
                        </div>

                        <div class="terms-content">
                            {!! $termsOfService->content !!}
                        </div>

                        @if (!$termsOfService->content)
                            <!-- محتوى افتراضي في حالة عدم وجود محتوى في قاعدة البيانات -->
                            <div class="section-box">
                                <h2>مقدمة</h2>
                                <p>مرحبًا بك في شروط الخدمة الخاصة بـ [اسم الشركة]. باستخدامك لموقعنا الإلكتروني وخدماتنا،
                                    فإنك توافق على الالتزام بهذه الشروط والأحكام. يرجى قراءتها بعناية.</p>
                                <p>تحدد هذه الشروط القواعد والأنظمة المتعلقة باستخدام موقعنا وخدماتنا.</p>
                            </div>

                            <div class="section-box">
                                <h2>تعريفات</h2>
                                <ul>
                                    <li><strong>"الشركة"</strong> أو <strong>"نحن"</strong> أو <strong>"لنا"</strong> تشير
                                        إلى [اسم الشركة].</li>
                                    <li><strong>"الخدمات"</strong> تعني الخدمات التي تقدمها شركتنا من خلال موقعنا
                                        الإلكتروني.</li>
                                    <li><strong>"أنت"</strong> تشير إلى الشخص أو الكيان الذي يستخدم موقعنا وخدماتنا.</li>
                                    <li><strong>"الموقع"</strong> يعني موقعنا الإلكتروني المتاح على [عنوان الموقع].</li>
                                </ul>
                            </div>

                            <div class="section-box">
                                <h2>استخدام الموقع والخدمات</h2>
                                <p>من خلال الوصول إلى موقعنا واستخدامه، فإنك تقر بأنك قرأت وفهمت وتوافق على الالتزام بهذه
                                    الشروط. إذا كنت لا توافق على أي جزء من هذه الشروط، يجب عليك عدم استخدام موقعنا أو
                                    خدماتنا.</p>
                                <p>أنت مسؤول عن ضمان أن جميع الأشخاص الذين يصلون إلى موقعنا من خلال اتصالك بالإنترنت على
                                    دراية بهذه الشروط والأحكام ويلتزمون بها.</p>
                            </div>

                            <div class="section-box">
                                <h2>التسجيل والحسابات</h2>
                                <p>عند إنشاء حساب معنا، يجب عليك تقديم معلومات دقيقة وكاملة وحديثة في جميع الأوقات. قد يؤدي
                                    عدم القيام بذلك إلى مخالفة الشروط، مما قد يؤدي إلى الإنهاء الفوري لحسابك على خدمتنا.</p>
                                <p>أنت مسؤول عن الحفاظ على سرية حسابك وكلمة المرور، وعن تقييد الوصول إلى جهاز الكمبيوتر أو
                                    الجهاز المحمول الخاص بك، وتوافق على تحمل المسؤولية عن جميع الأنشطة التي تحدث تحت حسابك
                                    أو كلمة المرور.</p>
                            </div>

                            <div class="section-box">
                                <h2>الملكية الفكرية</h2>
                                <p>الموقع وجميع المحتويات والميزات والوظائف (بما في ذلك على سبيل المثال لا الحصر جميع
                                    المعلومات والبرامج والنصوص والعروض والصور والفيديو والصوت، والتصميم واختيار وترتيبها) هي
                                    مملوكة للشركة أو المرخصين أو مزودي الخدمة الآخرين، ومحمية بموجب قوانين حقوق النشر
                                    والعلامات التجارية.</p>
                                <p>لا يجوز لك نسخ أو تعديل أو إنشاء أعمال مشتقة من أو إعادة هندسة أو تفكيك أو محاولة استخراج
                                    الشفرة المصدرية أو بيع أو نقل أو ترخيص من الباطن أو نقل أي حقوق في الخدمات.</p>
                            </div>

                            <div class="section-box">
                                <h2>المحتوى المستخدم</h2>
                                <p>من خلال نشر المحتوى على موقعنا، فإنك تمنحنا الحق غير الحصري لاستخدام ونسخ وتوزيع وعرض هذا
                                    المحتوى في موقعنا وفي جميع وسائل الإعلام المرتبطة به.</p>
                                <p>أنت تقر وتضمن أن لديك جميع الحقوق اللازمة للمحتوى الذي تقوم بنشره، وأن هذا المحتوى لا
                                    ينتهك حقوق الملكية الفكرية لأي طرف ثالث.</p>
                            </div>

                            <div class="section-box">
                                <h2>المدفوعات والاشتراكات</h2>
                                <p>إذا اخترت التسجيل في خدمة اشتراك مدفوعة، فإنك توافق على دفع الرسوم المطبقة. سيتم إصدار
                                    فاتورة لك من خلال طريقة الدفع التي تختارها عند التسجيل.</p>
                                <p>جميع الاشتراكات تتجدد تلقائيًا ما لم تقم بإلغائها. يمكنك إلغاء اشتراكك في أي وقت من
                                    إعدادات حسابك.</p>
                            </div>

                            <div class="section-box">
                                <h2>حدود المسؤولية</h2>
                                <p>لن نتحمل المسؤولية تجاهك أو تجاه أي طرف ثالث عن أي خسارة أو ضرر، بما في ذلك على سبيل
                                    المثال لا الحصر الخسارة غير المباشرة أو التبعية أو العقابية، أو أي خسارة قد تنجم عن
                                    استخدامك لموقعنا أو خدماتنا.</p>
                            </div>

                            <div class="section-box">
                                <h2>التعديلات على الشروط</h2>
                                <p>نحتفظ بالحق في تعديل أو استبدال هذه الشروط في أي وقت وفقًا لتقديرنا الخاص. سنبذل جهودًا
                                    معقولة لإخطارك بأي تغييرات جوهرية قبل أن تصبح سارية المفعول.</p>
                                <p>استمرارك في استخدام موقعنا أو خدماتنا بعد نشر أي تغييرات يعني قبولك لهذه التغييرات.</p>
                            </div>

                            <div class="section-box">
                                <h2>القانون المطبق</h2>
                                <p>تخضع هذه الشروط للقوانين المعمول بها في [البلد] وتفسر وفقًا لها، دون اعتبار لتعارض أحكام
                                    القانون.</p>
                            </div>

                            <div class="section-box">
                                <h2>الاتصال بنا</h2>
                                <p>إذا كانت لديك أي أسئلة حول هذه الشروط، يرجى الاتصال بنا على:</p>
                                <ul>
                                    <li>البريد الإلكتروني: [البريد الإلكتروني للشركة]</li>
                                    <li>العنوان: [عنوان الشركة]</li>
                                    <li>الهاتف: [رقم هاتف الشركة]</li>
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
            // تمييز روابط شروط الخدمة في شريط التنقل
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === "{{ route('terms.of.service') }}") {
                    link.classList.add('active');
                }
            });
        });
    </script>
@endsection
