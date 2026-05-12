<footer id="footer" class="footer">
    <div class="container footer-top">
        <div class="row gy-4">
            <!-- معلومات الشركة -->
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                    <span class="sitename text-white">نور الوجود</span>
                </a>
                <p class="mt-3">شركة رائدة في مجال خدمات الصيانة العامة والديكور في الإمارات العربية المتحدة، نقدم
                    خدمات متكاملة بجودة عالية وأسعار منافسة بخبرة تزيد عن 15 عاماً.</p>

                <div class="social-links d-flex mt-4">
                    <a href="https://twitter.com/noorelwegood" target="_blank" class="twitter-link"><i
                            class="bi bi-twitter-x"></i></a>
                    <a href="https://facebook.com/noorelwegood" target="_blank" class="facebook-link"><i
                            class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com/noorelwegood" target="_blank" class="instagram-link"><i
                            class="bi bi-instagram"></i></a>
                    <a href="https://linkedin.com/company/noorelwegood" target="_blank" class="linkedin-link"><i
                            class="bi bi-linkedin"></i></a>
                    <a href="https://wa.me/{{ preg_replace('/\s+/', '', str_replace('+', '', $contactSection->whatsapp_number ?? ($contactSection->phone ?? '971521526060 '))) }}"
                        target="_blank" class="whatsapp-link"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <!-- روابط مفيدة -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>روابط مفيدة</h4>
                <ul>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}#about">من نحن</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('page', 'services') }}">الخدمات</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('blog.index') }}">المدونة</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('contact') }}">اتصل بنا</a></li>
                </ul>
            </div>

            <!-- خدماتنا -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>خدماتنا</h4>
                @php
                    $footerServices = \App\Models\ServiceItem::where('is_active', true)->orderBy('ordering')->get();
                @endphp
                <ul>
                    @foreach ($footerServices as $item)
                        <li><i class="bi bi-chevron-left"></i> <a
                                href="{{ route('service.details', $item->id) }}">{{ $item->title }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- مناطق الخدمة -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>نخدم في</h4>
                <ul>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}?area=dubai">دبي</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}?area=abudhabi">أبو ظبي</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}?area=sharjah">الشارقة</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}?area=ajman">عجمان</a></li>
                    <li><i class="bi bi-chevron-left"></i> <a href="{{ route('home') }}?area=alain">العين</a></li>
                </ul>
            </div>

            <!-- معلومات الاتصال -->
            <div class="col-lg-2 col-md-6 footer-contact">
                <h4>اتصل بنا</h4>
                <p>
                    الإمارات العربية المتحدة<br>
                    <strong>هاتف:</strong> +971508423094<br>
                    <strong>واتساب:</strong> +971521526060 <br>
                    <strong>البريد الإلكتروني:</strong> info@noorelwegood.com<br>
                </p>

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
                    <button type="submit" class="btn-subscribe"><i class="bi bi-send"></i></button>
                </form>
                @if (session('newsletter_success'))
                    <div class="mt-2 text-success">{{ session('newsletter_success') }}</div>
                @endif
                @if ($errors->has('email'))
                    <div class="mt-2 text-danger">{{ $errors->first('email') }}</div>
                @endif
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>{{ date('Y') }} حقوق النشر</span> <strong class="px-1 sitename">نور الوجود</strong> <span>جميع
                الحقوق محفوظة</span>
        </p>
        <div class="credits">
            تصميم وتطوير بواسطة <a href="https://pickod.com" target="_blank">PICKOD</a>
        </div>
    </div>
</footer>

<style>
    .footer {
        padding: 50px 0 20px;
        background-color: #0f1421;
        color: rgba(255, 255, 255, 0.8);
    }

    .footer h4 {
        font-size: 16px;
        font-weight: 700;
        position: relative;
        padding-bottom: 12px;
        color: #ffffff;
    }

    .footer h4::after {
        content: '';
        position: absolute;
        display: block;
        width: 30px;
        height: 2px;
        background: var(#f59c27);
        bottom: 0;
        right: 0;
    }

    .footer .footer-links {
        margin-bottom: 30px;
    }

    .footer .footer-links ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer .footer-links ul i {
        padding-left: 5px;
        color: var(--primary-color, #f59c27);
        font-size: 12px;
        line-height: 1;
    }

    .footer .footer-links ul li {
        padding: 10px 0;
        display: flex;
        align-items: center;
    }

    .footer .footer-links ul li:first-child {
        padding-top: 0;
    }

    .footer .footer-links ul a {
        color: rgba(255, 255, 255, 0.8);
        transition: 0.3s;
        display: inline-block;
        text-decoration: none;
    }

    .footer .footer-links ul a:hover {
        color: var(--primary-color, #3498db);
    }

    .footer .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 16px;
        margin-left: 10px;
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.1);
        transition: 0.3s;
    }

    .footer .social-links a:hover {
        color: #ffffff;
        background-color: var(--primary-color, #3498db);
    }

    .footer-contact p {
        margin-bottom: 10px;
    }

    .footer-contact form {
        display: flex;
        position: relative;
    }

    .footer-contact form input[type="email"] {
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 6px 15px;
        width: 100%;
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border-radius: 50px;
    }

    .footer-contact form button {
        border: 0;
        background: none;
        font-size: 16px;
        padding: 0 10px;
        background: var(--primary-color, #3498db);
        color: #ffffff;
        transition: 0.3s;
        border-radius: 50px;
    }

    .footer-contact form button:hover {
        background: rgba(52, 152, 219, 0.8);
    }

    .copyright {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 20px;
    }

    .copyright a {
        color: var(--primary-color, #3498db);
        text-decoration: none;
    }
</style>
