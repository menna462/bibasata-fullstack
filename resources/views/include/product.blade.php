@extends('welcome')
@section('content')
    <!-- nav down Section -->
    <div class="shop">
        <div class="shop-contan">
            <h1>{{ $category->name_en }}</h1>
            <p>
                <a href="{{ url('/') }}">Home</a>
                <span><i class="fas fa-chevron-left"></i></span>
                {{ $category->name_en }}
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
            <h2 class="text-center mb-5">Our Products</h2>
            <div class="row g-4 justify-content-center mt-4" id="products">
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
                                {{-- لو حابة تضيفي أسعار زي الكود التاني --}}
                                {{--
                            <div class="pro-price-group">
                                <span class="pro-price-new">{{ $product->price }} EGP</span>
                            </div>
                            --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
