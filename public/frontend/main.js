console.log("main.js loaded");

window.addEventListener("load", function () {
    console.log("Page fully loaded");

    try {
        if (typeof Swiper !== "undefined") {
            // Hero swiper
            if (document.querySelector(".mySwiper")) {
                window.heroSwiper = new Swiper(".mySwiper", {
                    loop: true,
                    pagination: { el: ".swiper-pagination" },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
                console.log("heroSwiper initialized");
            }

            // Products swiper
            if (document.querySelector(".products-swiper")) {
                window.productsSwiper = new Swiper(".products-swiper", {
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    pagination: { el: ".products-pagination", clickable: true },
                    navigation: {
                        nextEl: ".products-button-next",
                        prevEl: ".products-button-prev",
                    },
                });
                console.log("productsSwiper initialized");
            }

            // Categories swiper
            if (document.querySelector(".allcard")) {
                window.categoriesSwiper = new Swiper(".allcard", {
                    loop: true,
                    slidesPerView: 5,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: ".categories-next",
                        prevEl: ".categories-prev",
                    },
                    breakpoints: {
                        // من أول 0 لحد 400px
                        0: {
                            slidesPerView: 2,
                        },
                        // من 401px لحد 1024px
                        401: {
                            slidesPerView: 3,
                        },
                        // من 1025px وأكبر
                        1025: {
                            slidesPerView: 5,
                        },
                    },
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                });
                console.log("categoriesSwiper initialized");
            }

            // Reviews swiper
            if (document.querySelector(".myReviewsSwiper")) {
                window.reviewsSwiper = new Swiper(".myReviewsSwiper", {
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
                    pagination: {
                        el: ".reviews-pagination",
                        clickable: true,
                    },
                });

                setTimeout(() => {
                    window.reviewsSwiper.update();
                    console.log("reviewsSwiper updated after load");
                }, 300);
            }
        } else {
            console.warn("Swiper library NOT loaded");
        }
    } catch (err) {
        console.error("Swiper init error:", err);
    }

    // ===== Pagination logic =====
    const products = document.querySelectorAll(".pro-card");
    const pagination = document.getElementById("pagination");
    const dropdownBtn = document.getElementById("dropdownMenuButton");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    if (pagination && products.length > 0) {
        let currentPage = 1;
        let itemsPerPage = parseInt(dropdownBtn?.textContent) || 10;

        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = page * itemsPerPage;
            products.forEach((product, index) => {
                product.style.display =
                    index >= start && index < end ? "block" : "none";
            });
        }

        function setupPagination() {
            pagination.innerHTML = "";
            const pageCount = Math.max(
                1,
                Math.ceil(products.length / itemsPerPage)
            );
            for (let i = 1; i <= pageCount; i++) {
                const btn = document.createElement("button");
                btn.type = "button";
                btn.textContent = i;
                btn.classList.add("btn", "btn-light", "m-1");
                if (i === currentPage) btn.classList.add("active");
                btn.addEventListener("click", () => {
                    currentPage = i;
                    showPage(currentPage);
                    setupPagination();
                });
                pagination.appendChild(btn);
            }
        }

        document.body.addEventListener("click", function (e) {
            const clicked = e.target.closest(".dropdown-item");
            if (!clicked) return;
            if (!clicked.closest(".dropdown-menu")) return;

            e.preventDefault();
            const val = parseInt(clicked.textContent.trim());
            if (!isNaN(val) && val > 0) {
                itemsPerPage = val;
                currentPage = 1;
                if (dropdownBtn)
                    dropdownBtn.textContent = clicked.textContent.trim();
                showPage(currentPage);
                setupPagination();
                console.log("Items per page changed to", itemsPerPage);
            }
        });

        showPage(currentPage);
        setupPagination();
        console.log("Pagination initialized:", {
            products: products.length,
            itemsPerPage,
        });
    }

    // ===== Mobile menu toggle =====
    window.toggleMenu = function () {
        const menu = document.getElementById("mobile-menu");
        if (!menu) {
            console.warn("mobile-menu element not found");
            return;
        }
        menu.classList.toggle("open");
    };
});

// ===== Tabs content =====
function showContent(contentId, event) {
    var contents = document.getElementsByClassName("tab-content");
    for (var i = 0; i < contents.length; i++) {
        contents[i].classList.remove("active");
    }

    var buttons = document.getElementsByClassName("tab-button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("active");
    }

    document.getElementById(contentId).classList.add("active");
    event.currentTarget.classList.add("active");

    if (contentId === "reviewsContent" && window.reviewsSwiper) {
        setTimeout(() => {
            window.reviewsSwiper.update();
            console.log("reviewsSwiper updated after tab shown");
        }, 100);
    }
}

// ===== Favorites toggle =====
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".favorite-icon").forEach(function (icon) {
        icon.addEventListener("click", function () {
            toggleFavorite(this);
        });
    });
});

function toggleFavorite(icon) {
    const favoritableId = icon.dataset.favoritableId;
    const favoritableType = icon.dataset.favoritableType;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/toggle-favorite`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            favoritable_id: favoritableId,
            favoritable_type: favoritableType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'added') {
            icon.classList.remove('far');
            icon.classList.add('fas', 'favorited');
            updateFavoritesCount(1); // ✅ زود العدد 1
        } else if (data.status === 'removed') {
            icon.classList.remove('fas', 'favorited');
            icon.classList.add('far');
            updateFavoritesCount(-1); // ✅ قلل العدد 1
        } else if (data.status === 'unauthenticated') {
            alert('Please log in to add to favorites');
        }
    })
    .catch(error => console.error('Error:', error));
}

// 🔥 فانكشن لتحديث العداد
function updateFavoritesCount(change) {
    const badge = document.querySelector(".icon-link .badge");
    if (badge) {
        let currentCount = parseInt(badge.textContent);
        let newCount = currentCount + change;

        if (newCount > 0) {
            badge.textContent = newCount;
        } else {
            badge.remove(); // لو مفيش مفضلات يشيل البادج
        }
    } else if (change > 0) {
        // لو مفيش بادج وضاف مفضلة أول مرة
        const iconLink = document.querySelector(".icon-link");
        const newBadge = document.createElement("span");
        newBadge.classList.add("badge");
        newBadge.textContent = change;
        iconLink.appendChild(newBadge);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.querySelector('.search-icon');
    const searchContainer = document.querySelector('.search-input-container');

    // دالة التبديل بين الظهور والإخفاء
    searchIcon.addEventListener('click', function(event) {
        // منع السلوك الافتراضي للرابط
        event.preventDefault();

        // تبديل حالة الظهور
        if (searchContainer.style.display === 'none' || searchContainer.style.display === '') {
            searchContainer.style.display = 'flex'; // استخدام flex أو block
            searchContainer.querySelector('.search-input').focus();
        } else {
            searchContainer.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        const isClickInside = searchContainer.contains(event.target) || searchIcon.contains(event.target);
        if (!isClickInside && searchContainer.style.display !== 'none') {
            searchContainer.style.display = 'none';
        }
    });
});



    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.querySelector('.custom-quantity-input');
        const priceElement = document.getElementById('current-price');
        const durationRadios = document.querySelectorAll('.duration-radio');
        const durationLabels = document.querySelectorAll('.duration-option');

        // ===================================
        // 1. وظيفة محدد الكمية (Quantity Selector)
        // ===================================
        document.querySelectorAll('.custom-quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                const action = this.getAttribute('data-action');

                if (action === 'increment') {
                    quantityInput.value = currentValue + 1;
                } else if (action === 'decrement' && currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        });

        // ===================================
        // 2. وظيفة اختيار المدة وتحديث السعر
        // ===================================
        durationLabels.forEach(label => {
            label.addEventListener('click', function() {
                // إزالة فئة 'active' من كل الأزرار
                durationLabels.forEach(lbl => lbl.classList.remove('active'));

                // إضافة فئة 'active' للزر الحالي
                this.classList.add('active');

                // الحصول على راديو الزر المقابل
                const radioId = this.getAttribute('for');
                const selectedRadio = document.getElementById(radioId);

                if (selectedRadio) {
                    selectedRadio.checked = true;
                    // تحديث السعر المعروض
                    updatePriceDisplay(selectedRadio.getAttribute('data-price'));
                }
            });
        });

        function updatePriceDisplay(newPrice) {
            if (priceElement && newPrice !== null) {
                // تنسيق السعر كعملة (افترضنا أنك تستخدم اللغتين الإنجليزية والعربية)
                // يمكن تعديل التنسيق حسب العملة
                const formattedPrice = parseFloat(newPrice).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                priceElement.textContent = `Rs. ${formattedPrice}`;
            }
        }
    });

