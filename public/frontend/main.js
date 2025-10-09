window.addEventListener("load", function () {
    console.log("Page fully loaded");

    try {
        if (typeof Swiper !== "undefined") {
            // Hero swiper
            if (document.querySelector(".mySwiper")) {
                window.heroSwiper = new Swiper(".mySwiper", {
                    loop: true,
                    // autoplay: {
                    //     delay: 3000, // المدة بين كل سلايد والتانية (3 ثواني)
                    //     disableOnInteraction: false, // يفضل شغال حتى لو المستخدم لمس السلايدر
                    // },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true, // يخلي النقاط قابلة للضغط
                    },
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
                    spaceBetween: 15,
                    navigation: {
                        nextEl: ".categories-next",
                        prevEl: ".categories-prev",
                    },
                    breakpoints: {
                        // من أول 0 لحد 400px
                        0: {
                            slidesPerView: 3,
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
                    // autoplay: {
                    //     delay: 3000,
                    //     disableOnInteraction: false,
                    // },
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
     const searchIcons = document.querySelectorAll(".search-icon");

    searchIcons.forEach(icon => {
        const container = icon.parentElement.querySelector(".search-input-container");

        if (!container) return;

        icon.addEventListener("click", function (event) {
            event.preventDefault();

            // إغلاق أي سيرش تاني مفتوح
            document.querySelectorAll(".search-input-container").forEach(el => {
                if (el !== container) el.style.display = "none";
            });

            // تبديل الحالة
            if (container.style.display === "none" || container.style.display === "") {
                container.style.display = "flex";
                container.querySelector(".search-input").focus();
            } else {
                container.style.display = "none";
            }
        });
    });

    document.addEventListener("click", function (event) {
        const isInside = event.target.closest(".search-toggle-li");
        if (!isInside) {
            document.querySelectorAll(".search-input-container").forEach(el => {
                el.style.display = "none";
            });
        }
    });

    console.log("Search toggle initialized ✅");


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

function updateFavoritesCount(change) {
    // يستهدف الرابط الذي يحتوي على ايقونة المفضلة (الذي يحمل كلاس icon-link)
    const badgeContainer = document.querySelector(".icon-link");
    if (!badgeContainer) {
        console.warn("Favorite counter link not found. Check if the element has class 'icon-link'.");
        return;
    }

    let badge = badgeContainer.querySelector(".badge");

    // إذا كان هناك بادج بالفعل
    if (badge) {
        let currentCount = parseInt(badge.textContent || 0);
        let newCount = currentCount + change;

        if (newCount > 0) {
            badge.textContent = newCount;
        } else {
            badge.remove(); // إزالة البادج إذا أصبح العدد صفر
        }
    } else if (change > 0) {
        // إذا لم يكن هناك بادج وتمت الإضافة لأول مرة
        const newBadge = document.createElement("span");
        newBadge.classList.add("badge");
        newBadge.textContent = change;
        badgeContainer.appendChild(newBadge);
    }
}

/**
 * 2. دالة AJAX الرئيسية لإضافة/إزالة المفضلة.
 * @param {HTMLElement} iconElement - عنصر الأيقونة <i> نفسه الذي تم النقر عليه.
 */
function toggleFavorite(iconElement) {
    const favoritableId = iconElement.dataset.favoritableId;
    const favoritableType = iconElement.dataset.favoritableType;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    // تعطيل الزر مؤقتاً لتجنب النقرات المتعددة
    const button = iconElement.closest('button');
    if (button) {
        button.disabled = true;
    }

    fetch(`/toggle-favorite`, { // المسار الذي عرفته في ملف routes/web.php
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
    .then((response) => response.json())
    .then((data) => {
        if (data.status === "added") {
            // تحديث الأيقونة: من فارغة (far) إلى ممتلئة (fas)
            iconElement.classList.remove("far", "fa-heart");
            iconElement.classList.add("fas", "fa-heart", "favorited");
            updateFavoritesCount(1);
        } else if (data.status === "removed") {
            // تحديث الأيقونة: من ممتلئة (fas) إلى فارغة (far)
            iconElement.classList.remove("fas", "fa-heart", "favorited");
            iconElement.classList.add("far", "fa-heart");
            updateFavoritesCount(-1);
        } else if (data.status === "unauthenticated") {
             // بما أن الكنترولر لم يعد يرجع هذه الحالة، هذا الكود نظرياً لن يعمل الآن
             // ولكنه يوضح أنك كنت تتعامل معه. الكنترولر الحالي أصبح يحفظ في الجلسة.
             console.log("Logged as guest, saved to session.");
        } else {
            console.error("Favorite toggle failed:", data.message || "Unknown error");
        }
    })
    .catch((error) => console.error("Error:", error))
    .finally(() => {
        // إعادة تفعيل الزر
        if (button) {
            button.disabled = false;
        }
    });
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


document.addEventListener("DOMContentLoaded", function () {
    const productData = document.getElementById("product-data");
    let currency = productData ? productData.dataset.currency : "USD";
    const priceEl = document.getElementById("current-price");

    function updatePriceFromRadio(radio) {
        const usd = radio.dataset.priceUsd
            ? parseFloat(radio.dataset.priceUsd)
            : 0;
        const egp = radio.dataset.priceEgp
            ? parseFloat(radio.dataset.priceEgp)
            : 0;
        const price = currency === "EGP" ? egp : usd;
        const symbol = currency === "EGP" ? " ج.م " : "$";
        priceEl.textContent = symbol + Number(price).toFixed(2);
    }

    const radios = document.querySelectorAll(".duration-radio");
    radios.forEach((r) =>
        r.addEventListener("change", function () {
            updatePriceFromRadio(this);
        })
    );

    const checked =
        document.querySelector(".duration-radio:checked") || radios[0];
    if (checked) updatePriceFromRadio(checked);
});
document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll(".custom-quantity-selector")
        .forEach(function (selector) {
            const input = selector.querySelector(".custom-quantity-input");
            const decrementBtn = selector.querySelector(
                "[data-action='decrement']"
            );
            const incrementBtn = selector.querySelector(
                "[data-action='increment']"
            );

            decrementBtn.addEventListener("click", function () {
                let value = parseInt(input.value) || 1;
                if (value > 1) {
                    input.value = value - 1;
                }
            });

            incrementBtn.addEventListener("click", function () {
                let value = parseInt(input.value) || 1;
                input.value = value + 1;
            });
        });
});

$(document).ready(function () {
    const $cartBadge = $(".icon-link .badge");

    $(".pro-add-to-cart").on("click", function (e) {
        e.preventDefault();

        const $button = $(this);
        const durationPriceId = $button.data("duration-price-id");
        const quantity = $button.data("quantity") || 1;
        const url = $button.data("cart-url");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        // تحقق بسيط
        if (!durationPriceId || durationPriceId === 0) {
            console.error("Error: durationPriceId is missing or zero.");
            alert("فشل الإضافة: لم يتم تحديد سعر المنتج.");
            return;
        }

        // 3. إرسال طلب AJAX POST
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                // إرسال البيانات المطلوبة بواسطة دالة add في الكنترولر
                duration_price_id: durationPriceId,
                quantity: quantity,
                _token: csrfToken, // رمز الأمان
            },
            beforeSend: function () {
                // تعطيل الزر أثناء عملية الإرسال
                $button.prop("disabled", true).text("جارٍ الإضافة...");
            },
            success: function (response) {
                // 4. معالجة الرد الناجح

                // تحديث أيقونة السلة بالعدد الجديد المرسل من الكنترولر
                if (response.cartCount !== undefined) {
                    $cartBadge.text(response.cartCount);
                    // إذا كان العدد أكبر من صفر، تأكد من إظهار الـ badge
                    if (response.cartCount > 0) {
                        $cartBadge.show();
                    }
                }

                alert(response.message); // يمكنك استبدالها برسالة أفضل
            },
            error: function (xhr) {
                // 5. معالجة الأخطاء
                let errorMessage = "فشل إضافة المنتج. يرجى إعادة المحاولة.";
                if (xhr.status === 419) {
                    errorMessage = "انتهت صلاحية الجلسة، يرجى تحديث الصفحة.";
                } else if (xhr.status === 422) {
                    // خطأ التحقق (Validation)
                    errorMessage = "البيانات المرسلة غير صحيحة.";
                }
                console.error("AJAX Error:", xhr.responseText);
                alert(errorMessage);
            },
            complete: function () {
                $button.prop("disabled", false).text("Add to cart");
            },
        });
    });
});

$(document).ready(function () {
    $(".pro-go-to-details").on("click", function (e) {
        e.preventDefault();
        const detailsRoute = $(this).data("product-details-route");

        if (detailsRoute) {
            window.location.href = detailsRoute;
        } else {
            console.error(
                "خطأ: المسار الخاص بتفاصيل المنتج غير موجود على الزر."
            );
        }
    });
});



function openSharePopup(productId, title, url) {
  // نجيب النافذة الخاصة بالمنتج ده
  const popup = document.getElementById(`sharePopup-${productId}`);
  popup.style.display = 'flex';

  const encodedTitle = encodeURIComponent(title);
  const encodedUrl = encodeURIComponent(url);

  // نعيّن روابط المشاركة
  popup.querySelector('.facebookShare').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
  popup.querySelector('.whatsappShare').href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
  popup.querySelector('.twitterShare').href = `https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`;
  popup.querySelector('.instagramShare').href = `https://www.instagram.com/`; // إنستجرام ما بيدعم المشاركة المباشرة
}

function closeSharePopup(productId) {
  document.getElementById(`sharePopup-${productId}`).style.display = 'none';
}


// إعداد روابط المشاركة
function setShareLinks(title, url) {
  const encodedTitle = encodeURIComponent(title);
  const encodedUrl = encodeURIComponent(url);

  document.getElementById('facebookShare').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
  document.getElementById('whatsappShare').href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
  document.getElementById('twitterShare').href = `https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`;
  document.getElementById('instagramShare').href = `https://www.instagram.com/`; // إنستجرام ما بيدعم المشاركة المباشرة
}

// لما الصفحة تجهز
document.addEventListener('DOMContentLoaded', function() {
  // هنا بتحطى بيانات المنتج من الـ Blade
  const title = "{{ $productShareTitle }}";
  const url = "{{ $productShareUrl }}";
  setShareLinks(title, url);
});




