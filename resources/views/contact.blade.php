<!-- Original phone field replaced with country code and phone input field -->
<div class="col-md-6">
    <div class="form-group phone-input-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <select name="country_id" id="country-code" class="form-control form-select">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" data-min="{{ $country->min_length }}"
                            data-max="{{ $country->max_length }}" data-code="{{ $country->country_code }}">
                            {{ $country->flag }} {{ $country->country_code }} ({{ $country->name_ar }})
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="tel" class="form-control" name="phone_number" id="phone-number" value=""
                placeholder="رقم الواتساب" pattern="[0-9]*" inputmode="numeric" maxlength="15">
        </div>
        <div class="invalid-feedback" id="phone-error"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countryCodeSelect = document.getElementById('country-code');
        const phoneNumberInput = document.getElementById('phone-number');
        const phoneError = document.getElementById('phone-error');
        const contactForm = document.getElementById('contactForm');

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
