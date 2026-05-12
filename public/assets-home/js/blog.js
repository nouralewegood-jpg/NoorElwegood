/**
 * Pikkod - Blog JavaScript
 * Created: April 28, 2025
 * Description: JavaScript functionality for blog pages
 */

document.addEventListener("DOMContentLoaded", function () {
    // Initialize blog search functionality
    initBlogSearch();

    // Add click events for blog sharing
    initBlogSharing();

    // Initialize blog comment form
    initCommentForm();

    // Add image gallery functionality to blog posts
    initBlogImageGallery();
});

/**
 * Initialize blog search functionality
 */
function initBlogSearch() {
    const searchForm = document.querySelector(".blog-search-form");
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[type="search"]');

        searchForm.addEventListener("submit", function (e) {
            if (searchInput && searchInput.value.trim() === "") {
                e.preventDefault();
                searchInput.classList.add("is-invalid");

                // Add shake animation
                searchInput.classList.add("shake");
                setTimeout(() => {
                    searchInput.classList.remove("shake");
                }, 600);
            } else if (searchInput) {
                searchInput.classList.remove("is-invalid");
            }
        });

        // Remove invalid state when user starts typing
        if (searchInput) {
            searchInput.addEventListener("input", function () {
                if (this.value.trim() !== "") {
                    this.classList.remove("is-invalid");
                }
            });
        }
    }
}

/**
 * Initialize blog sharing functionality
 */
function initBlogSharing() {
    const shareButtons = document.querySelectorAll(".blog-share-btn");

    shareButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const network = this.getAttribute("data-network");
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            let shareUrl = "";

            switch (network) {
                case "facebook":
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case "twitter":
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case "linkedin":
                    shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${title}`;
                    break;
                case "whatsapp":
                    shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                    break;
                case "telegram":
                    shareUrl = `https://t.me/share/url?url=${url}&text=${title}`;
                    break;
            }

            if (shareUrl) {
                window.open(
                    shareUrl,
                    "_blank",
                    "width=600,height=450,resizable=yes,scrollbars=yes"
                );
            }
        });
    });
}

/**
 * Initialize blog comment form
 */
function initCommentForm() {
    const commentForm = document.getElementById("blogCommentForm");

    if (commentForm) {
        commentForm.addEventListener("submit", function (e) {
            let isValid = true;

            // Basic form validation
            const requiredFields = commentForm.querySelectorAll("[required]");
            requiredFields.forEach((field) => {
                if (!field.value.trim()) {
                    field.classList.add("is-invalid");
                    isValid = false;
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            // Email validation
            const emailField = commentForm.querySelector('input[type="email"]');
            if (emailField && emailField.value.trim()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value)) {
                    emailField.classList.add("is-invalid");
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
            } else {
                // If form is valid and ajax is enabled, handle with fetch
                if (commentForm.getAttribute("data-ajax") === "true") {
                    e.preventDefault();

                    // Show loading state
                    const submitBtn = commentForm.querySelector(
                        'button[type="submit"]'
                    );
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري الإرسال...';

                    // Get form data
                    const formData = new FormData(commentForm);

                    // Send fetch request
                    fetch(commentForm.getAttribute("action"), {
                        method: "POST",
                        body: formData,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            // Reset form
                            commentForm.reset();

                            // Show success message
                            const messageContainer =
                                document.getElementById("commentResponse");
                            if (messageContainer) {
                                messageContainer.innerHTML = `
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i> ${
                                        data.message ||
                                        "تم إرسال تعليقك بنجاح، سيتم مراجعته ونشره قريبًا."
                                    }
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                                </div>
                            `;
                                messageContainer.style.display = "block";
                            }

                            // Scroll to message
                            messageContainer.scrollIntoView({
                                behavior: "smooth",
                            });
                        })
                        .catch((error) => {
                            console.error("Error:", error);

                            // Show error message
                            const messageContainer =
                                document.getElementById("commentResponse");
                            if (messageContainer) {
                                messageContainer.innerHTML = `
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i> حدث خطأ أثناء إرسال تعليقك. يرجى المحاولة مرة أخرى.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                                </div>
                            `;
                                messageContainer.style.display = "block";
                            }
                        })
                        .finally(() => {
                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        });
                }
            }
        });

        // Real-time validation
        const formFields = commentForm.querySelectorAll("input, textarea");
        formFields.forEach((field) => {
            field.addEventListener("input", function () {
                if (this.hasAttribute("required") && this.value.trim()) {
                    this.classList.remove("is-invalid");
                }

                // Sanitize inputs
                this.value = this.value.replace(/<\/?[^>]+(>|$)/g, "");
            });
        });
    }
}

/**
 * Initialize blog image gallery
 */
function initBlogImageGallery() {
    // Check if GLightbox is available
    if (typeof GLightbox !== "undefined") {
        // Initialize lightbox for blog post images
        const articleImages = document.querySelectorAll(
            ".blog-single-content img"
        );

        articleImages.forEach((img) => {
            // Skip images that are already wrapped in links
            if (!img.closest("a")) {
                // Create a wrapper link
                const wrapper = document.createElement("a");
                wrapper.href = img.src;
                wrapper.classList.add("glightbox");
                wrapper.setAttribute("data-gallery", "blog-gallery");
                wrapper.setAttribute("data-title", img.alt || "Blog Image");

                // Replace image with the wrapped version
                img.parentNode.insertBefore(wrapper, img);
                wrapper.appendChild(img);
            }
        });

        // Initialize GLightbox
        GLightbox({
            selector: ".glightbox",
            touchNavigation: true,
            loop: true,
        });
    }
}

/**
 * Handle "Read More" functionality for long blog excerpts
 */
function initReadMoreButtons() {
    const readMoreButtons = document.querySelectorAll(".read-more-btn");

    readMoreButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const contentId = this.getAttribute("data-target");
            const hiddenContent = document.getElementById(contentId);

            if (hiddenContent) {
                if (hiddenContent.classList.contains("d-none")) {
                    hiddenContent.classList.remove("d-none");
                    this.textContent = "عرض أقل";
                } else {
                    hiddenContent.classList.add("d-none");
                    this.textContent = "قراءة المزيد";
                }
            }
        });
    });
}

// Initialize read more functionality on page load
document.addEventListener("DOMContentLoaded", function () {
    initReadMoreButtons();

    // Add copy link button functionality
    const copyButtons = document.querySelectorAll(".copy-link-btn");
    copyButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            // Get current URL
            const url = window.location.href;

            // Create temporary textarea to copy from
            const tempInput = document.createElement("textarea");
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            // Show notification
            const tooltip = document.createElement("div");
            tooltip.classList.add("copy-tooltip");
            tooltip.textContent = "تم نسخ الرابط!";
            this.appendChild(tooltip);

            // Remove tooltip after animation
            setTimeout(() => {
                tooltip.remove();
            }, 2000);
        });
    });
});
