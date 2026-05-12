/**
 * Pikkod - Pages JavaScript
 * Created: April 28, 2025
 * Description: JavaScript functionality for static pages that appear to visitors
 */

document.addEventListener("DOMContentLoaded", function () {
    // Initialize AOS animations for page content
    initPageAnimations();

    // Handle service navigation highlighting
    initServiceNavigation();

    // Initialize image gallery for service pages
    initImageGallery();

    // Handle tab navigation for multi-tab pages
    initTabNavigation();
});

/**
 * Initialize page animations
 */
function initPageAnimations() {
    // Initialize AOS animations if they haven't been already
    if (typeof AOS !== "undefined" && AOS) {
        AOS.init({
            duration: 800,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }

    // Add scroll animation to page content
    const pageContentSections = document.querySelectorAll(".page-content-body");
    pageContentSections.forEach((section) => {
        if (!section.getAttribute("data-aos")) {
            section.setAttribute("data-aos", "fade-up");
            section.setAttribute("data-aos-delay", "100");
        }
    });
}

/**
 * Initialize service navigation links highlighting
 */
function initServiceNavigation() {
    const serviceLinks = document.querySelectorAll(".service-list a");
    if (serviceLinks.length > 0) {
        // Get current URL path
        const currentPath = window.location.pathname;

        // Loop through all service links
        serviceLinks.forEach((link) => {
            const linkPath = link.getAttribute("href");

            // Check if current path contains the link path
            if (linkPath && currentPath.includes(linkPath)) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    }
}

/**
 * Initialize image gallery for service pages
 */
function initImageGallery() {
    // Check if GLightbox is available
    if (typeof GLightbox !== "undefined") {
        const gallerySelector = ".glightbox";
        const galleryItems = document.querySelectorAll(gallerySelector);

        if (galleryItems.length > 0) {
            GLightbox({
                selector: gallerySelector,
                touchNavigation: true,
                loop: true,
                autoplayVideos: true,
            });
        }
    }
}

/**
 * Initialize tab navigation for multi-tab pages
 */
function initTabNavigation() {
    const tabLinks = document.querySelectorAll(".page-tabs .nav-link");
    if (tabLinks.length > 0) {
        tabLinks.forEach((tab) => {
            tab.addEventListener("click", function (e) {
                e.preventDefault();

                // Remove active class from all tabs
                tabLinks.forEach((t) => {
                    t.classList.remove("active");
                    t.setAttribute("aria-selected", "false");
                });

                // Add active class to current tab
                this.classList.add("active");
                this.setAttribute("aria-selected", "true");

                // Show corresponding content
                const target =
                    this.getAttribute("href") ||
                    this.getAttribute("data-bs-target");
                if (target) {
                    const tabContents = document.querySelectorAll(".tab-pane");
                    tabContents.forEach((content) => {
                        content.classList.remove("show");
                        content.classList.remove("active");
                    });

                    const activeContent = document.querySelector(target);
                    if (activeContent) {
                        activeContent.classList.add("show");
                        activeContent.classList.add("active");
                    }
                }
            });
        });
    }
}

/**
 * Handle blog search form
 */
function handleBlogSearch() {
    const searchForm = document.getElementById("blogSearchForm");
    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            const searchInput = document.getElementById("searchQuery");
            if (searchInput && searchInput.value.trim() === "") {
                e.preventDefault();
                searchInput.classList.add("is-invalid");
            } else {
                searchInput.classList.remove("is-invalid");
            }
        });
    }
}

/**
 * Handle image zoom on service pages
 */
function initImageZoom() {
    const serviceImages = document.querySelectorAll(
        ".service-img img, .page-content-body img"
    );
    serviceImages.forEach((img) => {
        // Add zoom functionality
        img.addEventListener("click", function () {
            if (!img.closest("a")) {
                // Only if image is not already wrapped in a link
                const src = this.getAttribute("src");
                const alt = this.getAttribute("alt") || "Image";

                // Create modal element
                const modal = document.createElement("div");
                modal.classList.add("image-zoom-modal");
                modal.innerHTML = `
                    <div class="image-zoom-content">
                        <img src="${src}" alt="${alt}">
                        <span class="close-zoom">&times;</span>
                    </div>
                `;

                // Add modal to body
                document.body.appendChild(modal);

                // Close modal on click
                modal.addEventListener("click", function () {
                    document.body.removeChild(modal);
                });
            }
        });
    });
}

/**
 * Handle contact form in sidebar
 */
function initSidebarContactForm() {
    const sidebarForm = document.querySelector(".sidebar-contact-form");
    if (sidebarForm) {
        sidebarForm.addEventListener("submit", function (e) {
            let isValid = true;

            // Validate required fields
            const requiredFields = sidebarForm.querySelectorAll("[required]");
            requiredFields.forEach((field) => {
                if (!field.value.trim()) {
                    field.classList.add("is-invalid");
                    isValid = false;
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            // Validate email format
            const emailField = sidebarForm.querySelector('input[type="email"]');
            if (emailField && emailField.value.trim()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value.trim())) {
                    emailField.classList.add("is-invalid");
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
}

// Initialize all page-specific functions
document.addEventListener("DOMContentLoaded", function () {
    handleBlogSearch();
    initImageZoom();
    initSidebarContactForm();

    // Check if the page has service navigation
    if (document.querySelector(".service-list")) {
        initServiceNavigation();
    }
});

// Handle back-to-top button
const scrollTop = document.getElementById("scroll-top");
if (scrollTop) {
    window.addEventListener("scroll", function () {
        if (this.scrollY > 100) {
            scrollTop.classList.add("active");
        } else {
            scrollTop.classList.remove("active");
        }
    });

    scrollTop.addEventListener("click", function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
}
