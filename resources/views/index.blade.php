<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>shop</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/bootstrap/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/Allcss/shop.css') }}" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- تحسين تحميل الخطوط -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100..900&display=swap" rel="stylesheet">

    <style>
        .favorite-icon { color: black; cursor: pointer; transition: color 0.3s; }
        .favorite-icon.favorited { color: red; }

        .language-dir { flex-direction: row-reverse; justify-content: flex-end; }
        .language-dir li.navli { margin-left: 15px; margin-right: 0; }

        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }

        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1.5s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div id="loading-screen">
        <div class="spinner"></div>
    </div>

    <!-- Top Bar for Large Screens -->
    <div class="top-bar d-none d-md-block">
        <div class="container">
            <p class="subscription-text">{{ __('language.subscription') }}</p>
            <div class="top-links">
                <a href="https://www.facebook.com/BibasataSoftAi"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/bibasatasoftai"><i class="fab fa-instagram"></i></a>
                <a href="https://wsend.co/201023290446"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="{{ route('contact') }}">{{ __('language.contact-us-navbar') }}</a>
                <a href="#">ENG</a>
            </div>
        </div>
    </div>
    <!-- Mobile Bar for Small Screens -->
    <div class="mobile-bar d-block d-md-none">
        <div class="container">
            <div class="sociel">
                <a href="https://www.facebook.com/BibasataSoftAi"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/bibasatasoftai"><i class="fab fa-instagram"></i></a>
                <a href="https://wsend.co/201023290446"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <!--end bar  -->
    <!-- Navbar -->
    <div class="container">
        <div class="row">
            <div class="navbar main-navbar-flex-container">
                <div class="menu-icon" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </div>

                <div class="logo">
                    <img src="{{ asset('frontend/images/BIBASATA-nav.png') }}" alt="Elite Logo" />
                </div>

                <div class="navbar-right-elements">
                    {{-- serch --}}
                    <div class="search-container mr-5 ml-5 d-none d-lg-block">
                        <form action="{{ route('frontend.search') }}" method="GET" class="search-form-flex">
                            <input type="text" name="query" placeholder="Search for products"
                                class="search-input-field" value="{{ request('query') }}" />
                            <div class="category-dropdown-custom">
                                <select aria-label="Select Category" name="category_id" class="category-select-field">
                                    <option value="all">{{ __('language.category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="search-submit-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="icons mr-2 d-block d-lg-none">
                        @auth
                            <a href="{{ route('favorites') }}" class="icon-link position-relative">
                                <i class="fa-regular fa-heart fa-lg" aria-hidden="true" style="font-size: 22px;"></i>
                                @php
                                    $favoritesCount = Auth::user()->allFavorites()->count();
                                @endphp
                                @if ($favoritesCount > 0)
                                    <span class="favorite-count-badge">
                                        {{ $favoritesCount }}
                                    </span>
                                @endif
                            </a>
                            @php
                                $cart = session()->get('cart', []);
                                $cartCount = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            <a href="{{ route('cart') }}" style="position: relative; margin-right: 3px;">
                                <i class="fas fa-shopping-cart fa-lg" aria-hidden="true" style="font-size: 22px;"></i>
                                @if ($cartCount > 0)
                                    <span class="cart-count-badge">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('profile.show') }}"><i class="fa-regular fa-circle-user fa-lg"></i></a>
                        @endauth
                    </div>

                    {{-- تسجيل الدخول --}}
                    {{-- <div class="d-none d-lg-block"> --}}
                    @include('login')
                    {{-- </div> --}}
{{-- ترجمه --}}
                    <div class="currency-select-wrapper">
                        <div class="currency-select" onclick="toggleCurrencyMenu()">
                            <div class="currency-selected">
                                @php
                                    $currentLocale = LaravelLocalization::getCurrentLocale();
                                    $currentProperties = LaravelLocalization::getSupportedLocales()[$currentLocale];

                                    $currentFlagUrl = match ($currentLocale) {
                                        'ar'
                                            => 'https://elitesoft-ai.com/wp-content/plugins/yaycurrency-pro/assets/dist/flags/eg.svg',
                                        'en'
                                            => 'https://elitesoft-ai.com/wp-content/plugins/yaycurrency-pro/assets/dist/flags/us.svg',
                                        default => '',
                                    };
                                @endphp

                                <span class="currency-flag" style="background-image: url('{{ $currentFlagUrl }}');">
                                </span>
                                <span class="currency-text">{{ $currentProperties['native'] }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>

                            <ul class="currency-options">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if ($localeCode !== $currentLocale)
                                        @php
                                            $flagUrl = match ($localeCode) {
                                                'ar'
                                                    => 'https://elitesoft-ai.com/wp-content/plugins/yaycurrency-pro/assets/dist/flags/eg.svg',
                                                'en'
                                                    => 'https://elitesoft-ai.com/wp-content/plugins/yaycurrency-pro/assets/dist/flags/us.svg',
                                                default => '',
                                            };
                                        @endphp
                                        <li>
                                            <a rel="alternate" hreflang="{{ $localeCode }}"
                                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                <span class="language-flag"
                                                    style="background-image: url('{{ $flagUrl }}'); display:inline-block; width: 20px; height: 15px; background-size: cover; margin-right: 5px;">
                                                </span>
                                                <span class="language-text">{{ $properties['native'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="container d-block d-lg-none my-2">
                    <form action="{{ route('frontend.search') }}" method="GET" class="search-form-flex">

                        <input type="text" name="query" placeholder="Search for products"
                            class="search-input-field" value="{{ request('query') }}" />

                        <div class="category-dropdown-custom"> {{-- ديف جديد لـ Select الخاص بالكاتجوريز --}}
                            <select aria-label="Select Category" name="category_id" class="category-select-field">
                                <option value="all">{{ __('language.category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="search-submit-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div id="overlay" onclick="toggleMenu('close')"></div>
                <div id="sidebar" class="sidebar">
                    <div class="close-btn" onclick="toggleMenu('close')">&times;</div>
                    <div class="menu-buttons">
                        <button onclick="toggleMenu('links')">menue</button>
                    </div>
                    <div class="menu-buttons">
                        <button onclick="toggleMenu('extra')">{{ __('language.browse') }}</button>
                    </div>
                    <div id="links" class="menu-section">
                        <a href="{{ route('home') }}">{{ __('language.Home') }}</a>
                        <a href="{{ route('shop') }}">{{ __('language.Shop') }}</a>
                        <a href="{{ route('about') }}">{{ __('language.About-Us') }} </a>
                        <a href="{{ route('contact') }}"> {{ __('language.Contact-Us') }}</a>
                        @if (Route::has('login'))
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="login-register-button">
                                        <span class="login-link">LOGOUT</span>
                                    </button>
                                </form>
                            @else
                                <button class="login-register-button">
                                    <a href="{{ route('login') }}" class="login-link">LOGIN</a> /
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="register-link">REGISTER</a>
                                    @endif
                                </button>
                            @endauth
                        @endif
                    </div>
                    <div id="extra" class="menu-section">
                        @foreach ($categories as $category)
                            <li class="list-group-item" onmouseover="showPopup('popup-{{ $category->id }}')"
                                onmouseout="hidePopup('popup-{{ $category->id }}')">
                                <a href="{{ route('category.products', $category->id) }}" class="a-address">
                                    <i class="fas fa-box"></i> {{ $category->name }}
                                </a>
                                <div class="popup-box" id="popup-{{ $category->id }}">
                                    <ul>
                                        @foreach ($category->products as $product)
                                            <li><a
                                                    href="{{ route('product.details', ['id' => $product->id]) }}">{{ $product->name_en }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="container-fluid d-flex align-items-center justify-content-between py-2 px-4">
                <button class="btn category-sidebar-toggle" data-toggle="collapse" data-target=".category-sidebar ">
                    <i class="fas fa-bars icon-one"></i>{{ __('language.browse') }}
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </button>
                <nav class="main-nav">
                    <ul class="left-links {{ app()->getLocale() == 'ar' ? 'language-dir' : '' }}">
                        <li class="navli"><a href="{{ route('home') }}">{{ __('language.Home') }}</a></li>
                        <li class="navli"><a href="{{ route('shop') }}">{{ __('language.Shop') }}</a></li>
                        <li class="navli"><a href="{{ route('about') }}">{{ __('language.About-Us') }} </a></li>
                        <li class="navli"><a href="{{ route('contact') }}">{{ __('language.Contact-Us') }}</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-lg-3 d-none d-lg-block">
                <aside class="category-sidebar active">
                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li class="list-group-item" onmouseover="showPopup('popup-{{ $category->id }}')"
                                onmouseout="hidePopup('popup-{{ $category->id }}')">
                                <a href="{{ route('category.products', $category->id) }}" class="a-address">
                                    <i class="fas fa-box"></i> {{ $category->name }}
                                </a>
                                <div class="popup-box" id="popup-{{ $category->id }}">
                                    <ul>
                                        @foreach ($category->products as $product)
                                            <li><a
                                                    href="{{ route('product.details', ['id' => $product->id]) }}">{{ $product->name_en }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>

        </div>
    </div>
    <!-- End Navbar -->
    @yield('content')

    <!--start footer  -->
    <div class="footer">
        <div class="footercontainer">
            <div class="social-icons">
                <a href="https://www.facebook.com/simplysoft.aii"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/simplysoft.ai"><i class="fab fa-instagram"></i></a>
                <a href="https://wsend.co/201023290446"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
            <div class="footernav">
                <ul>
                    <li class="navli"><a href="{{ route('home') }}">{{ __('language.Home') }}</a></li>
                    <li class="navli"><a href="{{ route('shop') }}">{{ __('language.Shop') }}</a></li>
                    <li class="navli"><a href="{{ route('about') }}">{{ __('language.About-Us') }} </a></li>
                    <li class="navli"><a href="{{ route('contact') }}">{{ __('language.Contact-Us') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="footerbootem">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 logo">
                        <img src={{ asset('frontend/images/BIBASATA-nav.png') }} alt="Image 1" />
                    </div>
                    <div class="col-md-6 text-center text-md-end buy">
                        <img src={{ asset('frontend/images/vodavon-removebg-preview.png') }} class="img-voda" />
                        <img src={{ asset('frontend/images/instapay.png') }} class="img-insta" />
                        <img src={{ asset('frontend/images/NBE-logo.svg') }} class="img-nbe" />
                        <img src={{ asset('frontend/images/pp.svg') }} class="img-pp" />
                        <img src={{ asset('frontend/images/binance2.png') }} class="img-binance" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end footer -->

 <!-- JS Scripts (مؤجلة) -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="{{ asset('frontend/js/main.js') }}" defer></script>
    <script src="{{ asset('frontend/bootstrap/js/jquery-3.7.1.min.js') }}" defer></script>
    <script src="{{ asset('frontend/bootstrap/js/popper.min.js') }}" defer></script>
    <script src="{{ asset('frontend/bootstrap/js/bootstrap.js') }}" defer></script>

    <script defer>
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('favorite-icon')) {
                const icon = e.target;
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
                        } else if (data.status === 'removed') {
                            icon.classList.remove('fas', 'favorited');
                            icon.classList.add('far');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const periodSelect = document.getElementById('period');
            const priceDisplay = document.querySelector('.product-details .price span:not(.old-price)');
            const durationPriceIdInput = document.getElementById('duration_price_id_input');
            const quantityInputHidden = document.getElementById('quantity_input_hidden');

            function updatePrice() {
                if (!periodSelect || !priceDisplay || periodSelect.options.length === 0) {
                    priceDisplay.textContent = 'N/A';
                    if (durationPriceIdInput) durationPriceIdInput.value = '';
                    return;
                }

                const selectedOption = periodSelect.options[periodSelect.selectedIndex];
                const basePrice = parseFloat(selectedOption.dataset.priceEgp);
                const durationId = selectedOption.dataset.durationId;

                if (!durationId) {
                    if (durationPriceIdInput) durationPriceIdInput.value = '';
                    return;
                }

                const quantity = 1;
                const totalPrice = basePrice * quantity;
                priceDisplay.textContent =
                    `${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} EGP`;

                if (durationPriceIdInput) durationPriceIdInput.value = durationId;
                if (quantityInputHidden) quantityInputHidden.value = quantity;
            }

            if (periodSelect) periodSelect.addEventListener('change', updatePrice);

            const addToCartForm = document.getElementById('add-to-cart-form');
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(event) {
                    updatePrice();
                    if (!durationPriceIdInput.value) {
                        event.preventDefault();
                        alert("Please select a valid period for the product.");
                    }
                });
            }

            updatePrice();
        });

        window.addEventListener('load', function() {
            var loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.opacity = '0';
                setTimeout(() => loadingScreen.style.display = 'none', 100);
            }
        });
    </script>
</body>

</html>
