<form action="{{ route('message.send') }}" method="post" class="php-email-form aos-animate" id="contactForm"
    data-aos="fade-up" data-aos-delay="200" style="opacity: 1; transform: translateZ(0px);">
    @csrf
    <!-- توكن الأمان للحماية من هجمات CSRF -->
    <input type="hidden" name="_contact_token" value="2df979cd3eab16e3ab932abf99a00009">

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="اسمك" value="{{ old('name') }}" maxlength="255" minlength="2" required
                    pattern="[^<>]*" title="يرجى إدخال اسم صالح بدون علامات خاصة">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" maxlength="255" placeholder="بريدك الإلكتروني" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group phone-input-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select name="country_id" id="country-code"
                            class="form-control form-select @error('country_id') is-invalid @enderror">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" data-min="{{ $country->min_length }}"
                                    data-max="{{ $country->max_length }}" data-code="{{ $country->country_code }}"
                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->flag }} {{ $country->country_code }} ({{ $country->name_ar }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                        name="phone_number" id="phone-number" value="{{ old('phone_number') }}"
                        placeholder="رقم الواتساب" pattern="[0-9]*" inputmode="numeric" maxlength="15">
                </div>
                <div class="invalid-feedback" id="phone-error">
                    @error('phone_number')
                        {{ $message }}
                    @enderror
                    @error('country_id')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject"
                    value="{{ old('subject') }}" maxlength="255" minlength="5" placeholder="موضوع الرسالة" required
                    pattern="[^<>]*" title="يرجى إدخال موضوع صالح بدون علامات خاصة">
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="6" minlength="10"
                    maxlength="5000" placeholder="رسالتك" required title="يرجى إدخال رسالة لا تقل عن 10 أحرف">{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <small class="text-muted" id="charCount">0 / 5000 حرف</small>
        </div>

        <!-- إضافة honeypot لحماية من بوتات السبام -->
        <div class="form-group d-none">
            <label for="contact_me_by_fax_only">اتركه فارغاً</label>
            <input type="checkbox" name="contact_me_by_fax_only" id="contact_me_by_fax_only" value="1">
            <input type="text" name="username" value="">
        </div>

        <!-- إضافة رمز التحقق (reCAPTCHA) -->

        <div class="col-12 text-center">
            <div class="loading">جاري التحميل</div>
            <div class="error-message"></div>
            <div class="sent-message">تم إرسال رسالتك بنجاح. شكرًا لك!</div>
            <button type="submit" id="submitBtn" class="btn" data-bs-toggle="tooltip" title="اضغط للإرسال">إرسال
                الرسالة</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countryCodeSelect = document.getElementById('country-code');
        const phoneNumberInput = document.getElementById('phone-number');
        const phoneError = document.getElementById('phone-error');
        const contactForm = document.getElementById('contactForm');
        const messageArea = document.querySelector('textarea[name="message"]');
        const charCount = document.getElementById('charCount');

        // عداد الحروف للرسالة
        if (messageArea && charCount) {
            // تحديث عدد الحروف عند تحميل الصفحة
            charCount.textContent = `${messageArea.value.length} / 5000 حرف`;

            // تحديث عدد الحروف عند الكتابة
            messageArea.addEventListener('input', function() {
                charCount.textContent = `${this.value.length} / 5000 حرف`;
            });
        }

        // ضبط الحد الأقصى للإدخال عند تحميل الصفحة
        if (countryCodeSelect.selectedOptions.length > 0) {
            const maxDigits = parseInt(countryCodeSelect.selectedOptions[0].dataset.max);
            phoneNumberInput.maxLength = maxDigits;
        }

        // التحقق من صحة رقم الهاتف عند تغيير مفتاح الدولة أو إدخال الرقم
        function validatePhoneNumber() {
            if (!phoneNumberInput.value) {
                // الرقم اختياري، لذلك لا داعي لعرض خطأ إذا كان فارغًا
                phoneError.textContent = '';
                phoneNumberInput.classList.remove('is-invalid');
                return true;
            }

            // التحقق من أن الإدخال يحتوي على أرقام فقط
            if (!/^\d+$/.test(phoneNumberInput.value)) {
                phoneError.textContent = 'يجب أن يحتوي رقم الهاتف على أرقام فقط';
                phoneNumberInput.classList.add('is-invalid');
                return false;
            }

            // الحصول على الحد الأدنى والأقصى للدولة المحددة
            const selectedOption = countryCodeSelect.selectedOptions[0];
            const minDigits = parseInt(selectedOption.dataset.min);
            const maxDigits = parseInt(selectedOption.dataset.max);
            const phoneLength = phoneNumberInput.value.length;

            // التحقق من طول الرقم
            if (phoneLength < minDigits || phoneLength > maxDigits) {
                const countryName = selectedOption.textContent.split('(')[1]?.split(')')[0] || 'المحددة';
                phoneError.textContent =
                    `عدد أرقام الهاتف ${countryName} يجب أن يكون بين ${minDigits} و ${maxDigits} رقمًا`;
                phoneNumberInput.classList.add('is-invalid');
                phoneError.style.display = 'block';
                return false;
            }

            // الرقم صحيح
            phoneError.textContent = '';
            phoneNumberInput.classList.remove('is-invalid');
            phoneError.style.display = 'none';
            return true;
        }

        // إضافة مستمعي الأحداث
        countryCodeSelect.addEventListener('change', function() {
            // تحديث الحد الأقصى لطول الإدخال عند تغيير الدولة
            const selectedOption = countryCodeSelect.selectedOptions[0];
            const maxDigits = parseInt(selectedOption.dataset.max);
            phoneNumberInput.maxLength = maxDigits;

            // إعادة التحقق من الرقم الحالي مع الدولة الجديدة
            validatePhoneNumber();
        });

        phoneNumberInput.addEventListener('input', validatePhoneNumber);

        // التحقق من النموذج بأكمله قبل الإرسال
        if (contactForm) {
            contactForm.addEventListener('submit', function(event) {
                if (phoneNumberInput.value && !validatePhoneNumber()) {
                    event.preventDefault(); // منع إرسال النموذج إذا كان هناك خطأ في رقم الهاتف
                }
            });
        }
    });
</script>
