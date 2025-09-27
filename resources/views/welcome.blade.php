<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <title>home</title>
</head>

<body>
    <header class="navbar">
        <div class="container-fluid">
            <button class="menu-btn d-lg-none" onclick="toggleMenu()">
                <i class="fa-solid fa-bars fa-2x"></i>
            </button>
            <div class="center-img">
                <img src="{{ asset('frontend/image/logo1.png') }}" alt="logo" />
            </div>

            {{-- Desktop Navigation --}}
            <div class="right-nav d-none d-lg-block">
                <ul>
                    <li><a href="{{ url('/') }}">{{ __('language.Home') }}</a></li>
                    <li><a href="{{ url('/shop') }}">{{ __('language.Shop') }}</a></li>
                    <li><a href="{{ url('/about') }}">{{ __('language.About') }}</a></li>
                    <li><a href="{{ url('/contact') }}">{{ __('language.Contact') }}</a></li>

                    @auth
                        <li><a href="{{ route('profile.show') }}">{{ __('language.Profile') }}</a></li>
                        <li><a href="{{ route('logout') }}">{{ __('language.Logout') }}</a></li>
                    @else
                        <li><a href="{{ route('login') }}">{{ __('language.Login') }}</a></li>
                        <li><a href="{{ route('register') }}">{{ __('language.Register') }}</a></li>
                    @endauth

                </ul>
            </div>

            {{-- Desktop Icons & Language Switcher --}}
            <div class="left-nav d-none d-lg-block">
                <ul class="icons">
                    <li>
                        @auth
                            <a href="{{ route('profile.show') }}"><i class="fa-regular fa-user"></i></a>
                        @else
                            <a href="{{ route('login') }}"><i class="fa-regular fa-user"></i></a>
                        @endauth
                    </li>

                    <li>
                        <a href="#" onclick="toggleSearch()" class="search-toggle-btn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('favorites') }}" class="icon-link position-relative">
                            <i class="fa-regular fa-heart fa-lg" aria-hidden="true"></i>
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
                            @auth
                                @php
                                    $cart = session()->get('cart', []);
                                    $cartCount = array_sum(array_column($cart, 'quantity'));
                                @endphp
                                @if ($cartCount > 0)
                                    <span class="badge">{{ $cartCount }}</span>
                                @endif
                            @endauth
                        </a>
                    </li>

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
                            <span class="currency-flag" style="background-image: url('{{ $currentFlagUrl }}');"></span>
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
                </ul>
            </div>

            {{-- Mobile Dropdown Menu --}}
            <div class="dropdown-menu-mobile" id="mobile-menu">
                <ul>
                    <li><a href="./index.html">Home</a></li>
                    <li><a href="./category.html">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <ul class="icons">
                    <li><a href="#"><i class="fa-regular fa-user"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                    <li><a href="#"><i class="fa-regular fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>

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
                </ul>
            </div>
        </div>
    </header>

    <!-- swiper -->
    @include('include.swiper')

    <!--  three -->
    @include('include.animation')
    <!-- category -->
    @include('include.categoryfront')

    <!-- card -->
    @include('include.carthome')

    <!-- bundle -->
    @include('include.bundel')


    @yield('content')

    <!-- footer -->
    <footer>
    <div class="footer-container">
        {{-- Social Media --}}
        <div class="footer-section social-media">
            <img src="{{ asset('frontend/image/7.png') }}" alt="Bibasata Logo" class="logo" />
            <h3>{{ __('footer.Social_Media') }}</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        {{-- Links --}}
        <div class="footer-section links">
            <h3>{{ __('footer.Links') }}</h3>
            <ul>
                <li><a href="{{ url('/') }}">{{ __('language.Home') }}</a></li>
                <li><a href="{{ url('/shop') }}">{{ __('language.Shop') }}</a></li>
                <li><a href="{{ url('/about') }}">{{ __('language.About') }}</a></li>
                <li><a href="{{ url('/contact') }}">{{ __('language.Contact') }}</a></li>
            </ul>
        </div>

        {{-- Popular Products --}}
        <div class="footer-section popular-products">
            <h3>{{ __('language.Popular_Products') }}</h3>
            <ul>
                <li><a href="#">Adobe</a></li>
                <li><a href="#">ChatGPT</a></li>
                <li><a href="#">Freebix</a></li>
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
            <p>&copy; 2025 Bibasata. {{ __('footer.All_Rights') }}</p>
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
    <script src="{{ asset('frontend/main.js') }}"></script>

</body>

</html>
