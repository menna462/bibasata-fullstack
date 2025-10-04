@extends('welcome')
@section('content')
    <!-- nav down Section -->

    <!-- nav down Section -->
    <div class="breadcrumb">
        <div class="container {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('language.home') }}</a></li>
                <li><a href="{{ route('shop') }}">{{ __('language.Shop') }}</a></li>
                <li class="divider"></li>
                <li class="current">{{ $product->$nameColumn }}</li>
            </ul>
        </div>
    </div>

    <div class="container my-5">
        <div class="row product-page-card rounded-4 p-4">
            <div class="col-lg-5 p-3 d-flex justify-content-cente flex-column align-items-centerr">
                <div class="card product-card border-0 rounded-4">
                    <img src="{{ asset('image/products/' . $product->image) }}" class="card-img-top rounded-4"
                        alt="{{ $product->$nameColumn }}" />
                </div>
            </div>

            <div class="col-lg-7 p-3 d-flex flex-column {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
                <div class="d-flex des-ti mb-3">
                    <h1 class="product-title">{{ $product->$nameColumn }}</h1>
                </div>

                <h2 class="product-price" id="current-price">
                    @if ($product->durations->isNotEmpty())
                        {{ format_price($product->durations->first()) }}
                    @else
                        {{ __('language.no_price') }}
                    @endif
                </h2>



                <p class="product-description mb-4">
                    {{ $product->$shortDescColumn ?? __('language.no_description') }}
                </p>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- ترجمة عنوان المدة --}}
                    <h5 class="duration-title mb-2">{{ __('language.duration') }}</h5>
                    <div id="product-data" data-currency="{{ session('user_currency', 'USD') }}"></div>

                    @foreach ($product->durations as $duration)
                        <input type="radio" id="duration-{{ $duration->id }}" name="duration_price_id"
                            value="{{ $duration->id }}" data-price-usd="{{ $duration->price_usd }}"
                            data-price-egp="{{ $duration->price_egp }}" class="d-none duration-radio"
                            @if ($loop->first) checked @endif>
                        <label for="duration-{{ $duration->id }}"
                            class="btn btn-outline-secondary duration-option @if ($loop->first) active @endif">
                            {{ $duration->duration_in_months }}
                            {{ $duration->duration_in_months == 1 ? __('language.month') : __('language.months') }}
                        </label>
                    @endforeach


                    <div class="d-flex align-items-center qu-custom mb-4 gap-2 mt-3">
                        <div class="input-group custom-quantity-selector">
                            <button class="btn custom-quantity-btn" type="button" data-action="decrement">-</button>
                            <input type="text" name="quantity" class="form-control text-center custom-quantity-input"
                                value="1" min="1" readonly />
                            <button class="btn custom-quantity-btn" type="button" data-action="increment">+</button>
                        </div>

                        <button class="btn custom-add-to-cart-btn" type="submit">
                            {{ __('language.add_to_cart') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="tab-buttons">
        <button class="tab-button active" onclick="showContent('descriptionContent', event)">
            Description
        </button>
        <button class="tab-button" onclick="showContent('reviewsContent', event)">
            Reviews
        </button>
    </div>

    <div class="container">
        <div id="descriptionContent" class="tab-content active">
            <p>
                {{ $product->{'long_description_' . app()->getLocale()} ?? __('language.no_description') }}

            </p>
        </div>

        <div id="reviewsContent" class="tab-content">
            <div class="add-comment-box">
                <div class="user-avatar">
                    <img src="../image/Ellipse3.png" alt="User Avatar" class="avatar-img" />
                </div>
                <div class="comment-input-area">
                    <input type="text" placeholder="Add a comment..." class="comment-input" />
                    <button class="post-button">Post</button>
                </div>
            </div>

            <div class="swiper myReviewsSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="review-section">
                            <div class="review-header">
                                <img src="../image/Ellipse3.png" alt="User Image" class="user-image" />
                                <div class="user-info">
                                    <h4>Armen Sargsyan</h4>
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                                <p class="review-date">1 month ago</p>
                            </div>
                            <div class="review-body">
                                <p>
                                    Embodying the raw, wayward spirit of rock 'n' roll, the
                                    Kilburn portable active stereo speaker takes the
                                    unmistakable look and sound of Marshall, unplugs the chords,
                                    and takes the show on the road.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-section">
                            <div class="review-header">
                                <img src="../image/Ellipse3.png" alt="User Image" class="user-image" />
                                <div class="user-info">
                                    <h4>Amira Khaled</h4>
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                                <p class="review-date">3 weeks ago</p>
                            </div>
                            <div class="review-body">
                                <p>
                                    The product quality is excellent and the design is very
                                    stylish. I highly recommend it!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-section">
                            <div class="review-header">
                                <img src="../image/Ellipse3.png" alt="User Image" class="user-image" />
                                <div class="user-info">
                                    <h4>Ahmed Gamal</h4>
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </div>
                                </div>
                                <p class="review-date">1 week ago</p>
                            </div>
                            <div class="review-body">
                                <p>
                                    This is the best item I've ever bought. It's truly amazing
                                    and the sound quality is top-notch.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination reviews-pagination"></div>
            </div>
        </div>
    </div>

    <!-- card -->
    <div class="pro-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('language.our_products') }}</h2>
            <div class="row g-4 justify-content-center  {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
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
                                        {{-- أيقونة المفضلة --}}
                                        <button class="btn pro-btn-icon">
                                            <i class="favorite-icon
                                        @if (Auth::check() &&
                                                Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) fas fa-heart favorited
                                        @else far fa-heart @endif"
                                                data-favoritable-id="{{ $product->id }}"
                                                data-favoritable-type="product">
                                            </i>{{ __('language.like') }}
                                        </button>

                                        {{-- زر المشاركة --}}
                                        <button class="btn pro-btn-icon">
                                            <i class="fas fa-share-alt"></i> {{ __('language.share') }}
                                        </button>
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
@endsection
