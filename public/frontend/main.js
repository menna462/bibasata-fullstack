document.addEventListener("DOMContentLoaded", function () {
    // ====== Swipers Initialization ======
    function initSwiper(selector, options) {
        if (document.querySelector(selector) && typeof Swiper !== "undefined") {
            return new Swiper(selector, options);
        }
        return null;
    }

    // Hero swiper
    window.heroSwiper = initSwiper(".mySwiper", {
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // Products swiper
    window.productsSwiper = initSwiper(".products-swiper", {
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: ".products-pagination", clickable: true },
        navigation: {
            nextEl: ".products-button-next",
            prevEl: ".products-button-prev",
        },
    });

    // Categories swiper
    window.categoriesSwiper = initSwiper(".allcard", {
        loop: true,
        slidesPerView: 5,
        spaceBetween: 10,
        navigation: { nextEl: ".categories-next", prevEl: ".categories-prev" },
        breakpoints: {
            0: { slidesPerView: 3 },
            401: { slidesPerView: 3 },
            1025: { slidesPerView: 5 },
        },
        autoplay: { delay: 3000, disableOnInteraction: false },
    });

    // Reviews swiper
    window.reviewsSwiper = initSwiper(".myReviewsSwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: { el: ".reviews-pagination", clickable: true },
        autoplay: { delay: 3000, disableOnInteraction: false },

    });

    if (window.reviewsSwiper) {
        setTimeout(() => window.reviewsSwiper.update(), 300);
    }

    // ====== Search Toggle ======
    const searchIcons = document.querySelectorAll(".search-icon");
    searchIcons.forEach((icon) => {
        const container = icon
            .closest(".search-toggle-li")
            .querySelector(".search-input-container");
        icon.addEventListener("click", function (e) {
            e.preventDefault();
            document
                .querySelectorAll(".search-input-container")
                .forEach((el) => {
                    if (el !== container) el.style.display = "none";
                });
            container.style.display =
                container.style.display === "flex" ? "none" : "flex";
            if (container.style.display === "flex")
                container.querySelector(".search-input").focus();
        });
    });
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".search-toggle-li")) {
            document
                .querySelectorAll(".search-input-container")
                .forEach((el) => (el.style.display = "none"));
        }
    });

    // ====== Mobile Menu ======
    window.toggleMenu = function () {
        const menu = document.getElementById("mobile-menu");
        if (menu) menu.classList.toggle("open");
    };

    // ====== Favorites Toggle ======
    function updateFavoritesCount(change) {
        const badgeContainer = document.querySelector(".icon-link");
        if (!badgeContainer) return;
        let badge = badgeContainer.querySelector(".badge");
        if (badge) {
            let count = parseInt(badge.textContent || 0) + change;
            if (count > 0) badge.textContent = count;
            else badge.remove();
        } else if (change > 0) {
            badge = document.createElement("span");
            badge.className = "badge";
            badge.textContent = change;
            badgeContainer.appendChild(badge);
        }
    }

    function toggleFavorite(icon) {
        const favoritableId = icon.dataset.favoritableId;
        const favoritableType = icon.dataset.favoritableType;
        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
        const button = icon.closest("button");
        if (button) button.disabled = true;

        fetch("/toggle-favorite", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                favoritable_id: favoritableId,
                favoritable_type: favoritableType,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.status === "added") {
                    icon.classList.replace("far", "fas");
                    icon.classList.add("favorited");
                    updateFavoritesCount(1);
                } else if (data.status === "removed") {
                    icon.classList.replace("fas", "far");
                    icon.classList.remove("favorited");
                    updateFavoritesCount(-1);
                }
            })
            .finally(() => {
                if (button) button.disabled = false;
            });
    }

    document.querySelectorAll(".favorite-icon").forEach((icon) => {
        icon.addEventListener("click", () => toggleFavorite(icon));
    });

    // ====== Price Update ======
    const productData = document.getElementById("product-data");
    const currency = productData ? productData.dataset.currency : "USD";
    const priceEl = document.getElementById("current-price");
    function updatePriceFromRadio(radio) {
        const usd = parseFloat(radio.dataset.priceUsd || 0);
        const egp = parseFloat(radio.dataset.priceEgp || 0);
        priceEl.textContent =
            (currency === "EGP" ? " ج.م " : "$") +
            Number(currency === "EGP" ? egp : usd).toFixed(2);
    }
    const radios = document.querySelectorAll(".duration-radio");
    radios.forEach((r) =>
        r.addEventListener("change", () => updatePriceFromRadio(r))
    );
    const checked =
        document.querySelector(".duration-radio:checked") || radios[0];
    if (checked) updatePriceFromRadio(checked);

    // ====== Quantity Selector ======
    document
        .querySelectorAll(".custom-quantity-selector")
        .forEach((selector) => {
            const input = selector.querySelector(".custom-quantity-input");
            selector
                .querySelector("[data-action='decrement']")
                .addEventListener("click", () => {
                    input.value = Math.max(1, parseInt(input.value) || 1 - 1);
                });
            selector
                .querySelector("[data-action='increment']")
                .addEventListener("click", () => {
                    input.value = (parseInt(input.value) || 1) + 1;
                });
        });

    // ====== Share Popup ======
    function setShareLinks(title, url) {
        const encodedTitle = encodeURIComponent(title);
        const encodedUrl = encodeURIComponent(url);
        [
            "facebookShare",
            "whatsappShare",
            "twitterShare",
            "instagramShare",
        ].forEach((id) => {
            const el = document.getElementById(id);
            if (!el) return;
            if (id === "facebookShare")
                el.href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
            else if (id === "whatsappShare")
                el.href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
            else if (id === "twitterShare")
                el.href = `https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`;
            else if (id === "instagramShare")
                el.href = `https://www.instagram.com/`;
        });
    }
    const title = "{{ $productShareTitle }}";
    const url = "{{ $productShareUrl }}";
    setShareLinks(title, url);

    window.openSharePopup = function (id, title, url) {
        const popup = document.getElementById(`sharePopup-${id}`);
        if (popup) {
            popup.style.display = "flex";
            const encodedTitle = encodeURIComponent(title);
            const encodedUrl = encodeURIComponent(url);
            popup.querySelector(
                ".facebookShare"
            ).href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
            popup.querySelector(
                ".whatsappShare"
            ).href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
            popup.querySelector(
                ".twitterShare"
            ).href = `https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`;
        }
    };
    window.closeSharePopup = function (id) {
        const popup = document.getElementById(`sharePopup-${id}`);
        if (popup) popup.style.display = "none";
    };

    // ====== Tabs ======
    window.showContent = function (contentId, event) {
        document
            .querySelectorAll(".tab-content")
            .forEach((c) => c.classList.remove("active"));
        document
            .querySelectorAll(".tab-button")
            .forEach((b) => b.classList.remove("active"));
        document.getElementById(contentId)?.classList.add("active");
        event.currentTarget.classList.add("active");
        if (contentId === "reviewsContent" && window.reviewsSwiper) {
            setTimeout(() => window.reviewsSwiper.update(), 100);
        }
    };
});
