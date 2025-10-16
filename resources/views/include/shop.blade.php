@extends('welcome')
@section('content')
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{ asset('image/slider/' . $slider->image) }}" alt="" />
                    <div class="slide-content">
                        <a href="{{ route('shop') }}" class="call-to-action-button"> BUY NOW </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <div class="shop">
        <div class="shop-contan">
            <h1>shop</h1>
            <p>
                Home <span> <i class="fas fa-chevron-left"></i></span> shop
            </p>
        </div>
    </div>

    <div class="filter-bar row justify-content-center text-center">
        <div class="left-section col-6 col-md-6 d-flex justify-content-center align-items-center  mb-md-0">
            <div class="filter-dropdown dropdown me-3">
                <button class="filter-option dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filter</span>
                </button>

                <ul class="filter-dropdown-menu dropdown-menu" data-bs-auto-close="true">
                    @foreach ($categories as $category)
                        <li>
                            <a class="dropdown-item" href="{{ route('category.products', $category->id) }}">
                                {{ $category->$nameColumn }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="vertical-divider"></div>
            <span class="results-text ms-3">Showing 1-16 of 32 results</span>
        </div>

        <div class="right-section col-6 col-md-6 d-flex justify-content-center align-items-center">
            <p class="show-button mb-0 me-2">Show</p>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    16
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">10</a></li>
                    <li><a class="dropdown-item" href="#">16</a></li>
                    <li><a class="dropdown-item" href="#">32</a></li>
                </ul>
            </div>
        </div>
    </div>


<div class="card-shop">
    <div class="container">
        <div class="row g-4 justify-content-center mt-4 {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}"
            id="products">
            @foreach ($products as $product)
                @php
                    $descriptionColumn = 'description_' . $currentLocale;
                @endphp
                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        {{-- صورة المنتج --}}
                        <img src="{{ asset('image/products/' . $product->image) }}" class="img-fluid"
                            alt="{{ $product->{$nameColumn} ?? $product->name_en }}" />

                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <a href="{{ route('product.details', ['id' => $product->id]) }}"
                                    class="btn pro-go-to-details">
                                    {{ __('language.home_details') }}
                                </a>

                                <div class="pro-btn-actions">
                                    @php
                                        // المنطق الأصلي لحساب حالة المفضلة للضيف (للعرض فقط)
                                        $isGuestFavorited = false;
                                        if (!Auth::check()) {
                                            $guestFavorites = session('guest_favorites', []);
                                            $modelClass = 'App\\Models\\Product';
                                            $key = $modelClass . '_' . $product->id;
                                            $isGuestFavorited = isset($guestFavorites[$key]);
                                        }

                                        // تحديد ما سيتم استدعاؤه عند الضغط
                                        if (Auth::check()) {
                                            $onClickAction = "toggleFavoriteAjax({$product->id}, 'product', this.querySelector('.favorite-icon'))";
                                        } else {
                                            $onClickAction = "window.location.href = '" . route('login') . "'";
                                        }

                                        $productShareUrl = route('product.details', ['id' => $product->id]);
                                        $productShareTitle = $product->name;
                                    @endphp

                                    {{-- أيقونة المفضلة --}}
                                    <button class="btn pro-btn-icon" onclick="{{ $onClickAction }}">
                                        <i class="favorite-icon
                                            @if (Auth::check() &&
                                                    Auth::user()->allFavorites()->where('favoritable_id', $product->id)
                                                        ->where('favoritable_type', 'App\Models\Product')
                                                        ->exists()) fas fa-heart favorited
                                            @else far fa-heart @endif"
                                            data-favoritable-id="{{ $product->id }}" data-favoritable-type="product">
                                        </i>{{ __('language.like') }}
                                    </button>

                                    {{-- زر المشاركة --}}
                                    <button class="btn pro-btn-icon"
                                        onclick="openSharePopup('{{ $product->id }}', '{{ $productShareTitle }}', '{{ $productShareUrl }}')">
                                        <i class="fas fa-share-alt"></i> {{ __('language.share') }}
                                    </button>

                                    {{-- النافذة المنبثقة --}}
                                    <div id="sharePopup-{{ $product->id }}" class="share-popup">
                                        <div class="share-content">
                                            <span class="close-btn"
                                                onclick="closeSharePopup('{{ $product->id }}')">&times;</span>
                                            <h5>شارك المنتج عبر</h5>
                                            <div class="share-icons">
                                                <a href="#" class="facebookShare" target="_blank"><i
                                                        class="fab fa-facebook-f"></i></a>
                                                <a href="#" class="whatsappShare" target="_blank"><i
                                                        class="fab fa-whatsapp"></i></a>
                                                <a href="#" class="instagramShare" target="_blank"><i
                                                        class="fab fa-instagram"></i></a>
                                                <a href="#" class="twitterShare" target="_blank"><i
                                                        class="fab fa-x-twitter"></i></a>
                                            </div>
                                            <button class="copy-link-btn"
                                                onclick="copyProductLink('{{ $productShareUrl }}', this)">
                                                <i class="fas fa-link"></i> {{ __('language.copy') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pro-content">
                            {{-- عرض اسم المنتج باللغة الحالية --}}
                            <div class="pro-title">{{ $product->{$nameColumn} }}</div>

                            {{-- عرض الوصف القصير باللغة الحالية فقط --}}
                            <div class="pro-description">{{ $product->{$descriptionColumn} }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="pagination"></div>
    </div>
</div>

@endsection
