@extends('welcome')
@section('content')
    <!-- swiper -->
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
    {{-- animation --}}
    @php
        // أول 3 منتجات
        $firstThree = $products->take(3);

        // باقي المنتجات
        $remainingProducts = $products->skip(3);
    @endphp

    <!-- القسم الأول - أول 3 منتجات -->
    <div class="tow-sections">
        @foreach ($firstThree as $product)
            <div class="section">
                <img src="{{ asset('image/products/' . $product->image) }}" alt="{{ $product->name_en }}" />
                <div class="text-row">
                    <p>{{ $product->{$nameColumn} }}</p>
                    <a href="{{ route('product.details', ['id' => $product->id]) }}">
                        <button>BUY NOW</button>
                    </a>
                </div>
            </div>
        @endforeach
    </div>


    <section class="section-container section-three">
        <div class="aksam">
            <h1>{{ __('language.main_categories') }}</h1>
        </div>
        <div class="swiper allcard">
            <div class="swiper-wrapper">
                @foreach ($categories as $category)
                    <div class="category-wrapper swiper-slide">
                        <a href="{{ route('category.products', $category->id) }}">
                            <div class="section-item">
                                <div class="section-icon">
                                    <img src="{{ asset('image/category/' . $category->image) }}" alt="" />
                                </div>
                            </div>
                            <p>{{ $category->$nameColumn }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev categories-prev"></div>
            <div class="swiper-button-next categories-next"></div>
        </div>
    </section>


    <div class="pro-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('language.our_products') }}</h2>
            <div class="row g-4 justify-content-center {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
                @foreach ($remainingProducts as $product)
                    @php
                        $descriptionColumn = 'description_' . $currentLocale;
                        $productShareUrl = route('product.details', ['id' => $product->id]);
                        $productShareTitle = $product->name;
                    @endphp

                    <div class="col-6 col-md-3">
                        <div class="pro-card">
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
                                            $isGuestFavorited = false;
                                            if (!Auth::check()) {
                                                $guestFavorites = session('guest_favorites', []);
                                                $modelClass = 'App\\Models\\Product';
                                                $key = $modelClass . '_' . $product->id;
                                                $isGuestFavorited = isset($guestFavorites[$key]);
                                            }

                                            if (Auth::check()) {
                                                $onClickAction = "toggleFavoriteAjax({$product->id}, 'product', this.querySelector('.favorite-icon'))";
                                            } else {
                                                $onClickAction = "window.location.href = '" . route('login') . "'";
                                            }
                                        @endphp

                                        <button class="btn pro-btn-icon" onclick="{{ $onClickAction }}">
                                            <i class="favorite-icon
                                            @if (
                                                (Auth::check() &&
                                                    Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) ||
                                                    $isGuestFavorited) fas fa-heart favorited
                                            @else
                                                far fa-heart @endif"
                                                data-favoritable-id="{{ $product->id }}" data-favoritable-type="product">
                                            </i>
                                            {{ __('language.like') }}
                                        </button>

                                        <!-- زر المشاركة -->
                                        <button class="btn pro-btn-icon"
                                            onclick="openSharePopup('{{ $product->id }}', '{{ $productShareTitle }}', '{{ $productShareUrl }}')">
                                            <i class="fas fa-share-alt"></i> {{ __('language.share') }}
                                        </button>

                                        <!-- النافذة المنبثقة -->
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
                                <div class="pro-title">{{ $product->{$nameColumn} }}</div>
                                <div class="pro-description">{{ $product->{$descriptionColumn} }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('shop') }}" class="btn pro-show-more-btn">
                    {{ __('language.show_more') }}
                </a>
            </div>
        </div>
    </div>



    <div class="swiper products-swiper container-fluid">
        <div class="swiper-wrapper">

            @foreach ($bundles as $bundle)
                @php
                    $name = $bundle->$nameColumn;
                    $description = $bundle->$descColumn;

                    $firstImage =
                        is_array($bundle->image) && count($bundle->image) > 0
                            ? $bundle->image[0]
                            : 'default_bundle.jpg';
                    $secondImage =
                        is_array($bundle->image) && count($bundle->image) > 1 ? $bundle->image[1] : $firstImage;
                @endphp

                <div class="swiper-slide">
                    <div class="slide-inner">
                        <div class="slide-content">
                            {{-- العنوان بناءً على اللغة المحددة --}}
                            <h3 class="slide-title">{{ $name }}</h3>

                            {{-- الوصف القصير بناءً على اللغة المحددة --}}
                            <p class="slide-desc">
                                {{ $description }}
                            </p>

                            {{-- زر يوجه إلى صفحة تفاصيل المنتج باستخدام الترجمة --}}
                            <a href="{{ route('bundle.details', $bundle->id) }}" class="call-to-action-button">
                                {{ __('language.explore_more') }}
                            </a>
                        </div>

                        <div class="slide-images">
                            <!-- الصورة الكبيرة: نستخدم الصورة الأولى -->
                            <div class="large-image">
                                <img src="{{ asset('image/products/' . $firstImage) }}"
                                    alt="{{ $name }} Large Image" />
                            </div>

                            <!-- الصورة الصغيرة: نستخدم الصورة الثانية -->
                            <div class="small-image">
                                <img src="{{ asset('image/products/' . $secondImage) }}"
                                    alt="{{ $name }} Small Image" />
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Pagination & Navigation -->
        <div class="swiper-pagination products-pagination"></div>
        <div class="swiper-button-prev products-button-prev"></div>
        <div class="swiper-button-next products-button-next"></div>
    </div>
@endsection
