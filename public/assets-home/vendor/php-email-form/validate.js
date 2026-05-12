/**
 * PHP Email Form Validation - v3.10
 * URL: https://bootstrapmade.com/php-email-form/
 * Author: BootstrapMade.com
 */
(function () {
    "use strict";

    let forms = document.querySelectorAll(".php-email-form");

    forms.forEach(function (e) {
        e.addEventListener("submit", function (event) {
            event.preventDefault();

            let thisForm = this;

            let action = thisForm.getAttribute("action");
            let recaptcha = thisForm.getAttribute("data-recaptcha-site-key");

            if (!action) {
                displayError(thisForm, "The form action property is not set!");
                return;
            }
            thisForm.querySelector(".loading").classList.add("d-block");
            thisForm
                .querySelector(".error-message")
                .classList.remove("d-block");
            thisForm.querySelector(".sent-message").classList.remove("d-block");

            let formData = new FormData(thisForm);

            if (recaptcha) {
                if (typeof grecaptcha !== "undefined") {
                    grecaptcha.ready(function () {
                        try {
                            grecaptcha
                                .execute(recaptcha, {
                                    action: "php_email_form_submit",
                                })
                                .then((token) => {
                                    formData.set("recaptcha-response", token);
                                    php_email_form_submit(
                                        thisForm,
                                        action,
                                        formData
                                    );
                                });
                        } catch (error) {
                            displayError(thisForm, error);
                        }
                    });
                } else {
                    displayError(
                        thisForm,
                        "The reCaptcha javascript API url is not loaded!"
                    );
                }
            } else {
                php_email_form_submit(thisForm, action, formData);
            }
        });
    });

    function php_email_form_submit(thisForm, action, formData) {
        fetch(action, {
            method: "POST",
            body: formData,
            headers: { "X-Requested-With": "XMLHttpRequest" },
        })
            .then((response) => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error(
                        `${response.status} ${response.statusText} ${response.url}`
                    );
                }
            })
            .then((data) => {
                thisForm.querySelector(".loading").classList.remove("d-block");
                // Modificado para aceptar diferentes tipos de respuestas exitosas
                if (
                    data.trim() == "OK" ||
                    data.includes("success") ||
                    data.includes('"status":"success"') ||
                    data.includes("تم إرسال رسالتك")
                ) {
                    thisForm
                        .querySelector(".sent-message")
                        .classList.add("d-block");
                    thisForm.reset();
                } else {
                    // Si la respuesta es una redirección (probablemente a la página principal)
                    if (
                        data.includes("<!DOCTYPE html>") ||
                        data.includes("<html")
                    ) {
                        thisForm
                            .querySelector(".sent-message")
                            .classList.add("d-block");
                        thisForm.reset();
                        // Opcionalmente, puedes redirigir después de un pequeño retraso
                        // setTimeout(() => { window.location.reload(); }, 2000);
                    } else {
                        throw new Error(
                            data
                                ? data
                                : "Form submission failed and no error message returned from: " +
                                  action
                        );
                    }
                }
            })
            .catch((error) => {
                displayError(thisForm, error);
            });
    }

    function displayError(thisForm, error) {
        thisForm.querySelector(".loading").classList.remove("d-block");
        thisForm.querySelector(".error-message").innerHTML = error;
        thisForm.querySelector(".error-message").classList.add("d-block");
    }
})();
