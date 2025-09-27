@extends('index')
@section('content')
 <div class="container my-5">
        <div class="product-container">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-image">
                        <img src="{{ asset('image/products/' . $product->image) }}" alt="{{ $product->name_en }}"
                            class="img-fluid" />
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="product-details">
                        <h2>{{ $product->name }}</h2>
                        <p class="features">
                            @if ($product->description)
                                @foreach (explode("\n", $product->description) as $feature)
                                    @if (trim($feature) !== '')
                                        &#x2714; {{ trim($feature) }}<br>
                                    @endif
                                @endforeach
                            @else
                                No specific features listed.
                            @endif
                        </p>

                        <form method="POST" action="{{ route('cart.add') }}" id="add-to-cart-form" class="w-100 mb-3"
                            style="display: flex; flex-direction: column; align-items: center;">
                            @csrf
                            <div class="row align-items-center mb-3"
                                style="display: flex; flex-direction: column; align-items: center;">
                                <div class="col-md-6 col-lg-5 mx-auto">
                                    <label for="period" class="text-center w-100">Period:</label>
                                    <div class="d-flex justify-content-center">
                                        <select id="period" name="duration_price_id" class="form-control form-control-sm w-auto">
                                            @if ($product->durations->isNotEmpty())
                                                @foreach ($product->durations->sortBy('duration_in_months') as $duration)
                                                    <option value="{{ $duration->id }}"
                                                        data-price-usd="{{ $duration->price_usd }}"
                                                        data-duration-in-days="{{ $duration->duration_in_days }}"
                                                        {{ $loop->first ? 'selected' : '' }}>
                                                        {{ $duration->duration_in_months }}
                                                        {{ $duration->duration_in_months == 1 ? 'month' : 'months' }}
                                                        ({{ number_format($duration->price_usd, 2) }} $)
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No periods available</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- تم حذف الحقول المخفية للـ duration_price_id و duration_in_days لأنها لم تعد ضرورية --}}
                            {{-- القيمة سترسل الآن مباشرة من الـ <select> --}}

                            <input type="hidden" name="quantity" id="quantity_input_hidden" value="1">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-success add-to-cart w-100">Add to Cart</button>
                        </form>

                        <div class="wishlist-share d-flex justify-content-between align-items-center">
                            <span class="wishlist">
                                <i class="favorite-icon
                                    @if (Auth::check() && Auth::user()->allFavorites()->where('favoritable_id', $product->id)->where('favoritable_type', 'App\Models\Product')->exists()) fas fa-heart favorited
                                    @else
                                        far fa-heart @endif
                                    "
                                    data-favoritable-id="{{ $product->id }}" data-favoritable-type="product"></i>
                                Add to Wishlist
                            </span>

                            <div class="share-icons">
                                <span>Share:</span>
                                <a href="https://www.facebook.com/BibasataSoftAi"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/bibasatasoftai"><i class="fab fa-instagram"></i></a>
                                <a href="https://wsend.co/201023290446"><i class="fa-brands fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-5" />
            <div class="product-description">
                <h2 class="description-title text-center mb-4">Description</h2>
                <div class="container">
                    @if ($product->long_description_en)
                        {!! nl2br(e($product->long_description_en)) !!}
                    @else
                        <p>No detailed description available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


