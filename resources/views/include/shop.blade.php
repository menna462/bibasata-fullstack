@extends('welcome')
@section('content')

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
                <button class="filter-option dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filter</span>
                </button>
                <ul class="filter-dropdown-menu dropdown-menu">
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
