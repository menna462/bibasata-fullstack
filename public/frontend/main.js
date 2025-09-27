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
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("favorite-icon")) {
        const icon = e.target;
        const favoritableId = icon.dataset.favoritableId;
        const favoritableType = icon.dataset.favoritableType;
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`/toggle-favorite`, {
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
                    icon.classList.remove("far");
                    icon.classList.add("fas", "favorited");
                } else if (data.status === "removed") {
                    icon.classList.remove("fas", "favorited");
                    icon.classList.add("far");
                }
            })
            .catch((error) => console.error("Error:", error));
    }
});
