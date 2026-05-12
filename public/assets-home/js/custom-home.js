/**
 * Custom Home JavaScript
 * Created: April 28, 2025
 * Description: Custom JavaScript functionality for the home page
 */

document.addEventListener("DOMContentLoaded", function () {
    // Features tabs functionality
    initFeaturesTabs();

    // Country selection in plan request form
    initCountrySelect();

    // Plan request form submission handling
    initPlanRequestForm();

    // Contact form character counter and validation
    initContactForm();
});

/**
 * Initialize features tabs section
 */
function initFeaturesTabs() {
    // Get all tab buttons in the features section
    const featuresTabs = document.querySelectorAll("#features .nav-link");

    // Add event listener to each button
    featuresTabs.forEach((tab) => {
        tab.addEventListener("click", function (e) {
            // Prevent default behavior
            e.preventDefault();

            // Remove active class from all buttons
            featuresTabs.forEach((t) => {
                t.classList.remove("active");
                t.classList.remove("show");
                t.setAttribute("aria-selected", "false");
            });

            // Add active class to current button
            this.classList.add("active");
            this.classList.add("show");
            this.setAttribute("aria-selected", "true");

            // Get the content target associated with the button
            const target = this.getAttribute("data-bs-target");

            // Hide all content panes
            const tabPanes = document.querySelectorAll("#features .tab-pane");
            tabPanes.forEach((pane) => {
                pane.classList.remove("active");
                pane.classList.remove("show");
            });

            // Show the content associated with the selected button
            if (target) {
                const targetPane = document.querySelector(target);
                if (targetPane) {
                    targetPane.classList.add("active");
                    targetPane.classList.add("show");
                }
            }
        });
    });
}

/**
 * Initialize country selection in plan request form
 */
function initCountrySelect() {
    const countrySelect = document.getElementById("countrySelect");
    const countryCodePrefix = document.getElementById("countryCodePrefix");

    if (countrySelect && countryCodePrefix) {
        countrySelect.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            const countryCode =
                selectedOption.getAttribute("data-country-code");
            countryCodePrefix.textContent = countryCode;
        });
    }
}

/**
 * Initialize plan request form submission
 */
function initPlanRequestForm() {
    const submitPlanButton = document.getElementById("submitPlanRequest");

    if (submitPlanButton) {
        submitPlanButton.addEventListener("click", function () {
            // Get data from form
            const clientName = document
                .getElementById("clientName")
                .value.trim();
            const countrySelect = document.getElementById("countrySelect");
            const clientPhone = document
                .getElementById("clientPhone")
                .value.trim();
            const projectDetails = document
                .getElementById("projectDetails")
                .value.trim();
            const planName = document
                .getElementById("selectedPlanName")
                .textContent.trim();
            const planPrice = document
                .getElementById("selectedPlanPrice")
                .textContent.trim();
            const planPeriod = document
                .getElementById("selectedPlanPeriod")
                .textContent.trim();

            // Validate data
            if (!clientName) {
                document
                    .getElementById("clientName")
                    .classList.add("is-invalid");
                return;
            } else {
                document
                    .getElementById("clientName")
                    .classList.remove("is-invalid");
            }

            if (countrySelect.selectedIndex === 0) {
                countrySelect.classList.add("is-invalid");
                return;
            } else {
                countrySelect.classList.remove("is-invalid");
            }

            if (!clientPhone) {
                document
                    .getElementById("clientPhone")
                    .classList.add("is-invalid");
                return;
            } else {
                document
                    .getElementById("clientPhone")
                    .classList.remove("is-invalid");
            }

            // Get data from selected country
            const selectedOption =
                countrySelect.options[countrySelect.selectedIndex];
            const countryCode =
                selectedOption.getAttribute("data-country-code");
            const country = selectedOption.getAttribute("data-country");

            // Show loading spinner
            const spinner = document.getElementById("submitSpinner");
            spinner.classList.remove("d-none");
            submitPlanButton.disabled = true;

            // Hide success and error messages
            document.getElementById("successMessage").classList.add("d-none");
            document.getElementById("errorMessage").classList.add("d-none");

            // Get CSRF token from meta tag
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            // Send data to server using Fetch API
            fetch("/submit-plan-request", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    client_name: clientName,
                    client_phone: countryCode + clientPhone,
                    client_country: country,
                    project_details: projectDetails,
                    plan_name: planName,
                    plan_price: planPrice,
                    plan_period: planPeriod,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    // Hide loading spinner
                    spinner.classList.add("d-none");

                    if (data.success) {
                        // Show success message
                        document
                            .getElementById("successMessage")
                            .classList.remove("d-none");
                        document.getElementById("successMessage").textContent =
                            data.message;

                        // Show WhatsApp button
                        document.getElementById(
                            "whatsappButton"
                        ).style.display = "inline-block";

                        // Reset form
                        document.getElementById("planRequestForm").reset();

                        // Disable submit button
                        submitPlanButton.style.display = "none";
                    } else {
                        // Show error message
                        document
                            .getElementById("errorMessage")
                            .classList.remove("d-none");
                        document.getElementById("errorMessage").textContent =
                            data.message;
                        submitPlanButton.disabled = false;
                    }
                })
                .catch((error) => {
                    // Hide loading spinner
                    spinner.classList.add("d-none");

                    // Show error message
                    document
                        .getElementById("errorMessage")
                        .classList.remove("d-none");
                    document.getElementById("errorMessage").textContent =
                        "حدث خطأ أثناء معالجة طلبك. يرجى المحاولة مرة أخرى.";
                    submitPlanButton.disabled = false;

                    console.error("Error:", error);
                });
        });
    }
}

/**
 * Initialize contact form handling
 */
function initContactForm() {
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        // Update character count in message field
        const messageField = contactForm.querySelector(
            'textarea[name="message"]'
        );
        const charCounter = document.getElementById("charCount");

        if (messageField && charCounter) {
            messageField.addEventListener("input", function () {
                const currentLength = this.value.length;
                charCounter.textContent = `${currentLength} / 5000 حرف`;

                // Change counter color if approaching the maximum limit
                if (currentLength > 4900) {
                    charCounter.classList.add("text-danger");
                } else {
                    charCounter.classList.remove("text-danger");
                }
            });

            // Trigger input event to set counter on page load
            const event = new Event("input");
            messageField.dispatchEvent(event);
        }

        // Prevent rapid repeated clicks on submit button
        const submitButton = contactForm.querySelector("#submitBtn");
        if (submitButton) {
            contactForm.addEventListener("submit", function (e) {
                // Disable button on submission to prevent repeated clicks
                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري الإرسال...';

                // Check honeypot
                const honeypot = contactForm.querySelector(
                    'input[name="contact_me_by_fax_only"]'
                );
                if (honeypot && honeypot.checked) {
                    e.preventDefault();
                    return false;
                }

                // Clean inputs before submission
                const inputs = contactForm.querySelectorAll(
                    'input[type="text"], input[type="email"], textarea'
                );
                inputs.forEach((input) => {
                    input.value = input.value.trim();
                });

                // Verify required fields
                let isValid = true;
                contactForm.querySelectorAll("[required]").forEach((field) => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add("is-invalid");
                    } else {
                        field.classList.remove("is-invalid");
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    submitButton.disabled = false;
                    submitButton.innerHTML =
                        contactForm.getAttribute("data-submit-text") ||
                        "إرسال الرسالة";
                    return false;
                }
            });
        }

        // Validate input fields in real time
        const validateField = function (field) {
            // Clean inputs from HTML tags
            field.value = field.value.replace(/<[^>]*>/g, "");

            // Check for suspicious patterns
            const suspiciousPatterns = [
                /javascript:/i,
                /on\w+=/i,
                /data:.*base64/i,
            ];

            for (const pattern of suspiciousPatterns) {
                if (pattern.test(field.value)) {
                    field.value = field.value.replace(pattern, "");
                }
            }
        };

        // Apply validation to text fields
        const textFields = contactForm.querySelectorAll(
            'input[type="text"], input[type="email"], textarea'
        );
        textFields.forEach((field) => {
            field.addEventListener("input", function () {
                validateField(this);
            });

            field.addEventListener("blur", function () {
                validateField(this);
            });
        });
    }
}

/**
 * Open the plan modal with details
 */
function openPlanModal(planName, planPrice, planPeriod) {
    const modal = new bootstrap.Modal(document.getElementById("planModal"));
    document.getElementById("selectedPlanName").textContent = planName;
    document.getElementById("selectedPlanPrice").textContent = planPrice;
    document.getElementById("selectedPlanPeriod").textContent = planPeriod;

    // Reset form and status messages
    document.getElementById("planRequestForm").reset();
    document.getElementById("successMessage").classList.add("d-none");
    document.getElementById("errorMessage").classList.add("d-none");
    document.getElementById("whatsappButton").style.display = "none";
    document.getElementById("submitPlanRequest").style.display = "inline-block";
    document.getElementById("submitPlanRequest").disabled = false;
    document.getElementById("submitSpinner").classList.add("d-none");

    // Remove validation state from fields
    document.getElementById("clientName").classList.remove("is-invalid");
    document.getElementById("countrySelect").classList.remove("is-invalid");
    document.getElementById("clientPhone").classList.remove("is-invalid");

    // Reset country code prefix
    document.getElementById("countryCodePrefix").textContent = "+xxx";

    modal.show();
}
