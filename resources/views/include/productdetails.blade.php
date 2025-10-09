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
                <hr />
                <div class="product-meta ">
                    <p style="color: black"><strong>Category:</strong> {{ $product->category->name ?? 'No category' }}</p>
                    <div class="detail-icon">
                        <span><strong>Share:</strong></span>
                        <div class="social-icons ms-3">
                            <a href="https://www.facebook.com/BibasataSoftAi" class="social-icon"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="https://wa.me/201023290446?text=مرحبًا%20عايزة%20استفسر%20عن%20المنتج" target="_blank"
                                class="social-icon">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="https://www.instagram.com/bibasatasoftai" class="social-icon"><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <div class="tab-buttons">
        <button class="tab-button active" onclick="showContent('descriptionContent', event)">
            {{ __('language.Description') }}
        </button>
        <button class="tab-button" onclick="showContent('reviewsContent', event)">
            {{ __('language.Reviews') }}

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

                <form action="{{ route('comments.store') }}" method="POST" class="comment-input-area">
                    @csrf
                    <input type="hidden" name="page_name" value="homepage">

                    @guest
                        <input type="text" name="guest_name" placeholder="Enter your name..." class="comment-input mb-2"
                            required>
                    @endguest

                    <div class="rating-stars mb-2" style="direction: rtl;">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating"
                                value="{{ $i }}" />
                            <label for="star{{ $i }}" title="{{ $i }} stars">★</label>
                        @endfor
                    </div>

                    <input type="text" name="content" placeholder="Add a comment..." class="comment-input" required>
                    <button type="submit" class="post-button">Post</button>
                </form>
            </div> <!-- end add-comment-box -->

            <div class="swiper myReviewsSwiper">
                <div class="swiper-wrapper">
                    @foreach ($comments as $comment)
                        <div class="swiper-slide">
                            <div class="review-section">
                                <div class="review-header">
                                    <img src="{{ asset('frontend/image/Ellipse3.png') }}" alt="User Image"
                                        class="user-image" />

                                    <div class="user-info">
                                        <div class="d-flex align-items-center gap-2">
                                            <h4 class="mb-0">
                                                {{ $comment->user ? $comment->user->name : $comment->guest_name }}
                                            </h4>
                                            <small class="text-muted">•
                                                {{ $comment->created_at->diffForHumans() }}</small>
                                        </div>

                                        <div class="rating mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $comment->rating)
                                                    <span class="fa fa-star checked"></span>
                                                @else
                                                    <span class="fa fa-star"></span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div> <!-- end user-info -->
                                </div> <!-- end review-header -->

                                <div class="review-body mt-2">
                                    <p class="mb-1">{{ $comment->content }}</p>

                                    @auth
                                        @if (Auth::id() === $comment->user_id)
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                class="delete-comment-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm mt-1 delete"> {{ __('language.delete') }}</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div> <!-- end review-body -->
                            </div> <!-- end review-section -->
                        </div> <!-- end swiper-slide -->
                    @endforeach
                </div> <!-- end swiper-wrapper -->

                <div class="swiper-pagination reviews-pagination"></div>
            </div>
        </div>


    </div>

    @php
        // المنتجات من بعد أول 3 منتجات
        $remainingProducts = $products->skip(3);
    @endphp
    <!-- card -->
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
                                                data-favoritable-id="{{ $product->id }}"
                                                data-favoritable-type="product">
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
@endsection
