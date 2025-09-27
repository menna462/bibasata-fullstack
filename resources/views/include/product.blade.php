@extends('index')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid"
        style="background-image: url('{{ asset('frontend/images/shop.png') }}'); background-size: cover; background-position: center; min-height: 400px;">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
            <h1 class="font-weight-semi-bold text-uppercase mb-3 text-white">{{ $category->name }}</h1>
            <div class="d-flex flex-wrap justify-content-center">
                @foreach ($categories as $cat)
                    <div class="category-item mx-3">
                        <a href="{{ route('category.products', $cat->id) }}" class="text-white category-link"
                            data-category="{{ $cat->name }}">
                            <h3>{{ $cat->name }}</h3>

                        </a>
                        <p class="text-white">{{ $cat->products_count }} Product</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Page Header End -->


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

    @php
        $productsChunked = $products->chunk(8);
    @endphp

    <div class="container my-5">
        @foreach ($productsChunked as $index => $productGroup)
            <div class="products-group {{ $index == 0 ? 'active' : '' }}" id="group-{{ $index + 1 }}">
                <div class="row">
                    @foreach ($productGroup as $product)
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="{{ asset('image/products/' . $product->image) }}"
                                        alt="{{ $product->name }}">
                                </div>
                                <div class="product-details">
                                    <div class="name-category">{{ $product->name }}</div>
                                    <div class="category">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </div>
                                </div>
                                <div class="product-overlay">
                                    <div class="product-description">
                                        {{ $product->description}}
                                    </div>
                                    <div class="product-actions">
                                        {{-- أيقونة القلب للمفضلة --}}
                                        <i class="favorite-icon left-icon
                                            @if (Auth::check() &&
                                                    Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) fas fa-heart {{-- قلب مليان لو مفضل --}}
                                            @else
                                                far fa-heart {{-- قلب فارغ لو مش مفضل --}} @endif
                                            "
                                            data-favoritable-id="{{ $product->id }}" data-favoritable-type="product"></i>

                                        {{-- زرار View Details الحالي --}}
                                        <a href="{{ route('product.details', ['id' => $product->id]) }}"
                                            class="btn btn-success">
                                            <span>View Details</span>
                                        </a>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
