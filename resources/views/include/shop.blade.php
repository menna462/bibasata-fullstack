@extends('welcome')
@section('content')
    {{-- <!-- Page Header Start -->
    <div class="container-fluid"
        style="background-image: url('{{ asset('frontend/images/shop.png') }}'); background-size: cover; background-position: center; min-height: 100px;">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 150px;">
            <h1 class="font-weight-semi-bold text-uppercase mb-3 text-white">Shop</h1>
            <div class="d-flex flex-wrap justify-content-center">
                @foreach ($categories as $cat)
                    <div class="category-item mx-3 text-center">
                        <a href="{{ route('category.products', $cat->id) }}" class="text-white category-link"
                            data-category="{{ $cat->name }}">
                            <h4>{{ $cat->name }}</h4>
                        </a>
                        <p class="text-white">{{ $cat->products_count }} Product</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- start products -->
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <!-- اللينكات على اليسار -->
            <div class="col-md-6">
                <span class="products fw-bold fs-4 me-3">PRODUCTS</span>
                <a href="#" class="tab-link active" data-tab="best-seller">BEST SELLER</a>
            </div>

            <!-- الأسهم على أقصى اليمين -->
            <div class="col-md-6 d-flex justify-content-end">
                <div class="nav-arrows">
                    <i class="fa-solid fa-chevron-left left-arrow"></i>
                    <i class="fa-solid fa-chevron-right right-arrow"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        @php
            $chunkedProducts = $products->chunk(8);
        @endphp

        <div class="products-slider">
            @foreach ($chunkedProducts as $index => $group)
                <div class="products-group {{ $index == 0 ? 'active' : '' }}" id="group-{{ $index + 1 }}">
                    <div class="row">
                        @foreach ($group as $product)
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        @if ($product->discount)
                                            <div class="discount-circle">-{{ $product->discount }}%</div>
                                        @endif
                                        <img src="{{ asset('image/products/' . $product->image) }}"
                                            alt="{{ $product->name }}" />
                                    </div>
                                    <div class="product-details">
                                        <div class="name-category">{{ $product->name }}</div>
                                        <div class="category">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </div>
                                    </div>
                                    <div class="product-overlay">
                                        <div class="product-description">
                                            {{ $product->description }}
                                        </div>
                                        <div class="product-actions">
                                            {{-- أيقونة القلب للمفضلة --}}
                                            <i class="favorite-icon left-icon
                                            @if (Auth::check() &&
                                                    Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) fas fa-heart favorited
                                            @else
                                                far fa-heart {{-- قلب فارغ لو مش مفضل --}} @endif
                                            "
                                                data-favoritable-id="{{ $product->id }}"
                                                data-favoritable-type="product"></i>

                                            {{-- زرار View Details الحالي --}}
                                            <a href="{{ route('product.details', ['id' => $product->id]) }}"
                                                class="btn btn-success">
                                                <span>View Details</span>
                                            </a>

                                            {{-- أيقونة سلة التسوق الحالية --}}
                                            <i class="fas fa-shopping-cart right-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
    <!-- end body shop -->

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="../image/HOME.png" alt="" />
                <div class="slide-content">
                    <a href="#" class="call-to-action-button"> BUY NOW </a>
                </div>
            </div>

            <div class="swiper-slide">
                <img src="../image/HOME.png" alt="" />
                <div class="slide-content">
                    <a href="#" class="call-to-action-button"> BUY NOW </a>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="../image/HOME.png" alt="" />
                <div class="slide-content">
                    <a href="#" class="call-to-action-button"> BUY NOW </a>
                </div>
            </div>
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
        <!-- القسم الشمال -->
        <div class="left-section col-12 col-md-6 d-flex justify-content-center align-items-center mb-3 mb-md-0">
            <div class="filter-dropdown dropdown me-3">
                <button class="filter-option dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filter</span>
                </button>
                <ul class="filter-dropdown-menu dropdown-menu">
                    <li><a class="dropdown-item" href="#">Category 1</a></li>
                    <li><a class="dropdown-item" href="#">Category 2</a></li>
                    <li><a class="dropdown-item" href="#">Category 3</a></li>
                </ul>
            </div>
            <div class="vertical-divider"></div>
            <span class="results-text ms-3">Showing 1-16 of 32 results</span>
        </div>

        <!-- القسم اليمين -->
        <div class="right-section col-12 col-md-6 d-flex justify-content-center align-items-center">
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
            <div class="row g-4 justify-content-center mt-4" id="products">
                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Syltherine" />

                        <span class="pro-badge pro-badge-new">New</span>
                        <span class="pro-badge pro-badge-discount">-30%</span>

                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pro-content">
                            <div class="pro-title">Syltherine</div>
                            <div class="pro-description">Stylish cafe chair</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 2.500.000</span>
                                <span class="pro-price-old">Rp 3.500.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pagination"></div>
        </div>
    </div>
@endsection
