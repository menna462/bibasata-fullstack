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

                                    {{-- أيقونة القلب للمفضلة التي أرسلتها --}}
                                    <button class="btn pro-btn-icon">
                                        <i class="favorite-icon
                                        @if (Auth::check() &&
                                                Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) fas fa-heart
                                        @else
                                                far fa-heart @endif"
                                            data-favoritable-id="{{ $product->id }}" data-favoritable-type="product">
                                        </i>
                                        Like
                                    </button>

                                    {{-- زرار share --}}
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
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

        <div class="text-center mt-5">
            <button class="btn pro-show-more-btn">Show More</button>
        </div>
    </div>
</div>
