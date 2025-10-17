<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Bibasata متجر لبيع المنتجات الرقمية والبرمجيات، يوفر تجربة تسوق سهلة وآمنة باللغتين العربية والإنجليزية. اشترك في النشرة الإخبارية للحصول على أحدث العروض.">
    <meta name="keywords"
        content="Bibasata, متجر إلكتروني, برمجيات, برامج, شراء برامج, منتجات رقمية, تطبيقات, شحن دولي, العربية, الإنجليزية">
    <meta name="author" content="Bibasata">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Almarai:wght@700&display=swap"
        rel="stylesheet">


    <title>home</title>
    <style>
        .icon-link {
            display: inline-block;
            position: relative;
            font-size: 1.5rem;
            color: #343a40;
            /* لون الأيقونة */
            transition: color 0.3s;
        }

        .icon-link:hover {
            color: #007bff;
            /* لون عند التحويم */
        }

        .icon-link .badge {
            position: absolute;
            /* في نظام RTL، نضع العداد في الزاوية العلوية اليسرى */
            top: -8px;
            left: -8px;
            padding: 3px 6px;
            border-radius: 50%;
            background-color: #dc3545;
            /* لون أحمر مميز */
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
            line-height: 1;
            z-index: 10;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-box {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="container-fluid">
            <button class="menu-btn d-lg-none" onclick="toggleMenu()">
                <i class="fa-solid fa-bars fa-2x"></i>
            </button>
            <div class="center-img">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('frontend/image/logo1.png') }}" alt="logo" />
                </a>
            </div>


            {{-- Desktop Navigation --}}
            <div class="right-nav d-none d-lg-block  {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
                <ul>
                    <li><a href="{{ url('/') }}">{{ __('language.Home') }}</a></li>
                    <li><a href="{{ url('/shop') }}">{{ __('language.Shop') }}</a></li>
                    <li><a href="{{ url('/about') }}">{{ __('language.About') }}</a></li>
                    <li><a href="{{ url('/contact') }}">{{ __('language.Contact') }}</a></li>

                    @auth
                        <li><a href="{{ route('profile.show') }}">{{ __('language.Profile') }}</a></li>

                        <li>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('language.Logout') }}
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li><a href="{{ route('login') }}">{{ __('language.Login') }}</a></li>
                        <li><a href="{{ route('register') }}">{{ __('language.Register') }}</a></li>
                    @endauth


                </ul>
            </div>

            {{-- Desktop Icons & Language Switcher --}}
            <div class="left-nav d-none d-lg-block">
                <ul class="icons">
                    {{-- أيقونة حساب المستخدم (تظل كما هي) --}}
                    <li>
                        @auth
                            <a href="{{ route('profile.show') }}"><i class="fa-regular fa-user"></i></a>
                        @else
                            <a href="{{ route('login') }}"><i class="fa-regular fa-user"></i></a>
                        @endauth
                    </li>

                    {{-- أيقونة البحث --}}
                    <li class="search-toggle-li">
                        <a href="javascript:void(0)" class="search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>

                        <form action="{{ route('frontend.search') }}" method="GET" class="search-input-container"
                            style="display: none;">
                            <input type="text" name="query" placeholder="ابحث هنا..." class="search-input"
                                value="{{ request('query') }}">
                            <button type="submit" class="search-btn">بحث</button>
                        </form>
                    </li>

                    {{-- أيقونة المفضلة (العداد يظهر فقط للمسجلين) --}}
                    <li>
                        <a href="{{ route('favorites') }}" class="icon-link position-relative"
                            id="favorites-count-link">
                            <i class="fa-regular fa-heart fa-lg" aria-hidden="true"></i>

                            @php
                                $favoritesCount = 0;
                                if (Auth::check()) {
                                    // للمسجلين: العدد من قاعدة البيانات
                                    $favoritesCount = Auth::user()->allFavorites()->count();
                                } else {
                                    // للضيوف: العدد من الجلسة
                                    // يتم حفظ المفضلة كـ [key => item_details] لذا نستخدم count
                                    $favoritesCount = count(session('guest_favorites', []));
                                }
                            @endphp

                            @if ($favoritesCount > 0)
                                {{-- هذا العنصر هو الذي يبحث عنه الجافاسكريبت لتحديثه --}}
                                <span class="badge" id="favorites-count-badge">{{ $favoritesCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart') }}" class="icon-link position-relative">
                            <i class="fa-solid fa-cart-shopping"></i>
                            @php
                                $cart = session()->get('cart', []);
                                $cartCount = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            @if ($cartCount > 0)
                                <span class="badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    {{-- قسم تبديل اللغة --}}
                    @php
                        $currentLocale = app()->getLocale();
                        $currentFlagUrl = match ($currentLocale) {
                            'ar'
                                => 'https://elitesoft-ai.com/wp-content/plugins/yaycurrency-pro/assets/dist/flags/eg.svg',
                            'en'
                                => 'https://elitesoft-ai.com/wp-content/plugins/yaycurrency-pro/assets/dist/flags/us.svg',
                            default => '',
                        };
                    @endphp

                    <li class="nav-item dropdown language-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdownDesktop" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="currency-flag"
                                style="background-image: url('{{ $currentFlagUrl }}');"></span>
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdownDesktop">
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
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <span class="language-flag"
                                                style="background-image: url('{{ $flagUrl }}');"></span>
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item dropdown language-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdownDesktop"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            💰 {{ session('user_currency', 'USD') }}
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="currencyDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('setCurrency', 'EGP') }}">
                                    {{ __('language.egpmany') }} </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('setCurrency', 'USD') }}">
                                    {{ __('language.usdmony') }} </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

            {{-- Mobile Dropdown Menu --}}
            {{-- Mobile Dropdown Menu --}}
            <div class="dropdown-menu-mobile {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}" id="mobile-menu">
                <ul>
                    <li><a href="{{ url('/') }}">{{ __('language.Home') }}</a></li>
                    <li><a href="{{ url('/shop') }}">{{ __('language.Shop') }}</a></li>
                    <li><a href="{{ url('/about') }}">{{ __('language.About') }}</a></li>
                    <li><a href="{{ url('/contact') }}">{{ __('language.Contact') }}</a></li>

                    @auth
                        <li><a href="{{ route('profile.show') }}">{{ __('language.Profile') }}</a></li>
                        <li>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                {{ __('language.Logout') }}
                            </a>
                        </li>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li><a href="{{ route('login') }}">{{ __('language.Login') }}</a></li>
                        <li><a href="{{ route('register') }}">{{ __('language.Register') }}</a></li>
                    @endauth
                </ul>

                <ul class="icons">
                    <li>
                        @auth
                            <a href="{{ route('profile.show') }}"><i class="fa-regular fa-user"></i></a>
                        @else
                            <a href="{{ route('login') }}"><i class="fa-regular fa-user"></i></a>
                        @endauth
                    </li>

                    <li class="search-toggle-li">
                        <a href="javascript:void(0)" class="search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                        <form action="{{ route('frontend.search') }}" method="GET" class="search-input-container"
                            style="display: none;">
                            <input type="text" name="query" placeholder="ابحث هنا..." class="search-input"
                                value="{{ request('query') }}">
                            <button type="submit" class="search-btn">بحث</button>
                        </form>
                    </li>

                    <li>
                        <a href="{{ route('favorites') }}" class="icon-link position-relative">
                            <i class="fa-regular fa-heart"></i>
                            @auth
                                @php $favoritesCount = Auth::user()->allFavorites()->count(); @endphp
                                @if ($favoritesCount > 0)
                                    <span class="badge">{{ $favoritesCount }}</span>
                                @endif
                            @endauth
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart') }}" class="icon-link position-relative">
                            <i class="fa-solid fa-cart-shopping"></i>
                            @php
                                $cart = session()->get('cart', []);
                                $cartCount = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            @if ($cartCount > 0)
                                <span class="badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item dropdown language-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdownMobile"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="currency-flag"
                                style="background-image: url('{{ $currentFlagUrl }}');"></span>
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdownMobile">
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
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <span class="language-flag"
                                                style="background-image: url('{{ $flagUrl }}');"></span>
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item dropdown language-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdownDesktop"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            💰 {{ session('user_currency', 'USD') }}
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="currencyDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('setCurrency', 'EGP') }}">

                                    {{ __('language.egpmany') }} </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('setCurrency', 'USD') }}">
                                    {{ __('language.usdmony') }}
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

        </div>
    </header>
    @yield('content')

    <!-- footer -->
    <footer>
        <div class="footer-container">
            {{-- Social Media --}}
            <div class="footer-section social-media">
                <img src="{{ asset('frontend/image/7.png') }}" alt="Bibasata Logo" class="logo" />
                <h3>{{ __('language.Social_Media') }}</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/BibasataSoftAi"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/201023290446?text=مرحبًا%20عايزة%20استفسر%20عن%20المنتج" target="_blank"
                        class="social-icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/bibasatasoftai"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            {{-- Links --}}
            <div class="footer-section links">
                <h3>{{ __('language.Links') }}</h3>
                <ul>
                    <li><a href="{{ url('/') }}">{{ __('language.Home') }}</a></li>
                    <li><a href="{{ url('/shop') }}">{{ __('language.Shop') }}</a></li>
                    <li><a href="{{ url('/about') }}">{{ __('language.About') }}</a></li>
                    <li><a href="{{ url('/contact') }}">{{ __('language.Contact') }}</a></li>
                    <li><a href="{{ url('/conditions') }}">{{ __('language.Term') }}</a></li>
                </ul>
            </div>

            {{-- Popular Products --}}
            <div class="footer-section popular-products">
                <h3>{{ __('language.Popular_Products') }}</h3>
                <ul>
                    @php
                        // تحديد العمود بناءً على اللغة الحالية
                        $nameColumn = app()->getLocale() == 'ar' ? 'name_ar' : 'name_en';
                    @endphp
                    @foreach ($categories->take(3) as $category)
                        <li>
                            <a href="{{ route('category.products', $category->id) }}">
                                {{ $category->$nameColumn }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="footer-section newsletter">
                <h3>{{ __('language.Newsletter') }}</h3>
                <form>
                    <input type="email" placeholder="{{ __('language.Email_Placeholder') }}" />
                    <button type="submit">{{ __('language.Subscribe') }}</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; 2025 Bibasata. {{ __('language.All_Rights') }}</p>
            </div>
        </div>
    </footer>

    <div class="payment-logos">
        <img src="{{ asset('frontend/image/11.jpg') }}" alt="Etisalat" />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('frontend/main.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const filterLinks = document.querySelectorAll('.filter-dropdown-menu .dropdown-item');

            filterLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.stopPropagation();
                    window.location.href = this.href;
                });
            });
        });
    </script>


</body>

</html>
