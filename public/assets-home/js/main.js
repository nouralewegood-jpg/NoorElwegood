/**
 * Main JavaScript file for the website
 */

document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    // Show content immediately before AOS initializes
    document.body.classList.add("content-loaded");

    /**
     * Preloader
     */
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    /**
     * Sticky Header on Scroll
     */
    const selectHeader = document.querySelector("#header");
    if (selectHeader) {
        let headerOffset = selectHeader.offsetTop;
        let nextElement = selectHeader.nextElementSibling;

        const headerFixed = () => {
            if (headerOffset - window.scrollY <= 0) {
                selectHeader.classList.add("sticked");
                if (nextElement)
                    nextElement.classList.add("sticked-header-offset");
            } else {
                selectHeader.classList.remove("sticked");
                if (nextElement)
                    nextElement.classList.remove("sticked-header-offset");
            }
        };
        window.addEventListener("load", headerFixed);
        document.addEventListener("scroll", headerFixed);
    }

    /**
     * Navbar Links Active State on Scroll
     */
    let navbarlinks = document.querySelectorAll("#navmenu a");

    function navbarlinksActive() {
        navbarlinks.forEach((navbarlink) => {
            if (!navbarlink.hash) return;

            let section = document.querySelector(navbarlink.hash);
            if (!section) return;

            let position = window.scrollY + 200;

            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                navbarlink.classList.add("active");
            } else {
                navbarlink.classList.remove("active");
            }
        });
    }
    window.addEventListener("load", navbarlinksActive);
    document.addEventListener("scroll", navbarlinksActive);

    /**
     * Mobile Nav Toggle
     */
    const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener("click", function (event) {
            event.preventDefault();
            document
                .querySelector("body")
                .classList.toggle("mobile-nav-active");
            this.classList.toggle("bi-list");
            this.classList.toggle("bi-x");
        });
    }

    /**
     * Toggle mobile nav dropdowns
     */
    const navDropdowns = document.querySelectorAll(".navmenu .dropdown > a");
    navDropdowns.forEach((el) => {
        el.addEventListener("click", function (event) {
            if (document.querySelector(".mobile-nav-active")) {
                event.preventDefault();
                this.classList.toggle("active");
                this.nextElementSibling.classList.toggle("dropdown-active");

                let dropDownIndicator = this.querySelector(
                    ".dropdown-indicator"
                );
                dropDownIndicator.classList.toggle("bi-chevron-up");
                dropDownIndicator.classList.toggle("bi-chevron-down");
            }
        });
    });

    /**
     * Initiate glightbox for media content
     */
    const glightbox = GLightbox({
        selector: ".glightbox",
    });

    /**
     * Scroll top button
     */
    const scrollTop = document.getElementById("scroll-top");
    if (scrollTop) {
        const togglescrollTop = function () {
            window.scrollY > 100
                ? scrollTop.classList.add("active")
                : scrollTop.classList.remove("active");
        };
        window.addEventListener("load", togglescrollTop);
        document.addEventListener("scroll", togglescrollTop);
        scrollTop.addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    /**
     * Initiate Pure Counter
     */
    new PureCounter();

    /**
     * Init swiper slider with 1 slide at once in desktop view
     */
    new Swiper(".slides-1", {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: "auto",
        pagination: {
            el: ".swiper-pagination",
            type: "bullets",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    /**
     * Animation on scroll function and init
     */
    function aosInit() {
        AOS.init({
            duration: 800,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }

    // Initialize AOS with fallback for content display
    try {
        setTimeout(function () {
            aosInit();
        }, 100);
    } catch (error) {
        console.error("AOS initialization error:", error);
        // Remove AOS attributes to ensure content visibility if AOS fails
        document.querySelectorAll("[data-aos]").forEach((el) => {
            el.removeAttribute("data-aos");
            el.style.opacity = "1";
        });
    }

    // Force show all content with AOS after a timeout as fallback
    setTimeout(function () {
        document.querySelectorAll("[data-aos]").forEach((el) => {
            if (!el.classList.contains("aos-animate")) {
                el.classList.add("aos-animate");
                el.style.opacity = "1";
            }
        });
    }, 1500);
});
