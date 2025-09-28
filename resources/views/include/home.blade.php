@extends('welcome')
@section('content')
    <!-- swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{ asset('image/slider/' . $slider->image) }}" alt="" />
                    <div class="slide-content">
                        <a href="#" class="call-to-action-button"> BUY NOW </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <div class="tow-sections">
        <div class="section">
            <img src="{{ asset('frontend/image/header.gif') }}" alt="" />
            <div class="text-row">
                <p>Original Windows</p>
                <button>BUY NOW</button>
            </div>
        </div>

        <div class="section">
            <img src="{{ asset('frontend/image/header3.gif') }}" alt="" />
            <div class="text-row">
                <p>Designers Tools</p>
                <button>BUY NOW</button>
            </div>
        </div>

        <div class="section">
            <img src="{{ asset('frontend/image/header1.gif') }}" alt="" />
            <div class="text-row">
                <p>AI Tools</p>
                <button>BUY NOW</button>
            </div>
        </div>
    </div>

    <section class="section-container section-three">
        <div class="aksam">
            <h1>{{ __('language.main_categories') }}</h1>
        </div>
        <div class="swiper allcard">
            <div class="swiper-wrapper">
                @foreach ($categories as $category)
                    <div class="category-wrapper swiper-slide">
                        <div class="section-item">
                            <div class="section-icon">
                                <img src="{{ asset('image/category/' . $category->image) }}" alt="" />
                            </div>
                        </div>
                        <p>{{ $category->$nameColumn }}</p>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev categories-prev"></div>
            <div class="swiper-button-next categories-next"></div>
        </div>
    </section>

    <div class="pro-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Products</h2>
            <div class="row g-4 justify-content-center">
                @foreach ($products as $product)
                    <div class="col-6 col-md-3">
                        <div class="pro-card">
                            {{-- صورة المنتج --}}
                            <img src="{{ asset('image/products/' . $product->image) }}" class="img-fluid"
                                alt="{{ $product->name_en }}" />

                            <div class="pro-overlay">
                                <div class="pro-hover-menu">
                                    <button class="btn pro-add-to-cart">Add to cart</button>
                                    <div class="pro-btn-actions">
                                        {{-- أيقونة المفضلة --}}
                                        <button class="btn pro-btn-icon">
                                            <i class="favorite-icon
                                            @if (Auth::check() &&
                                                    Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) fas fa-heart favorited
                                            @else far fa-heart @endif"
                                                data-favoritable-id="{{ $product->id }}" data-favoritable-type="product">
                                            </i>Like
                                        </button>

                                        {{-- زر المشاركة --}}
                                        <button class="btn pro-btn-icon">
                                            <i class="fas fa-share-alt"></i> Share
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="pro-content">
                                <div class="pro-title">{{ $product->name_en }}</div>
                                <div class="pro-description">{{ $product->description_en }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="swiper products-swiper container-fluid">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="slide-inner">
                    <div class="slide-content">
                        <h3 class="slide-title">Adobe Creative Cloud</h3>
                        <p class="slide-desc">
                            Our designer already made a lot of beautiful prototipe of rooms
                            that inspire you
                        </p>
                        <a href="#" class="call-to-action-button">Explore More</a>
                    </div>

                    <div class="slide-images">
                        <!-- الصورة الكبيرة -->
                        <div class="large-image">
                            <img src="{{ asset('frontend/image/bundle.jpg') }}" alt="Product Large" />
                        </div>

                        <!-- الصورة الصغيرة -->
                        <div class="small-image">
                            <img src="{{ asset('frontend/image/bundle.jpg') }}" alt="Product Small" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="slide-inner">
                    <div class="slide-content">
                        <h3 class="slide-title">Adobe Creative Cloud</h3>
                        <p class="slide-desc">
                            Our designer already made a lot of beautiful prototipe of rooms
                            that inspire you
                        </p>
                        <a href="#" class="call-to-action-button">Explore More</a>
                    </div>

                    <div class="slide-images">
                        <!-- الصورة الكبيرة -->
                        <div class="large-image">
                            <img src="{{ asset('frontend/image/bundle.jpg') }}" alt="Product Large" />
                        </div>

                        <!-- الصورة الصغيرة -->
                        <div class="small-image">
                            <img src="{{ asset('frontend/image/bundle.jpg') }}" alt="Product Small" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination & Navigation -->
        <div class="swiper-pagination products-pagination"></div>
        <div class="swiper-button-prev products-button-prev"></div>
        <div class="swiper-button-next products-button-next"></div>
    </div>
@endsection
