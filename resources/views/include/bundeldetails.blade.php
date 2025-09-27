@extends('index')
@section('content')
    <style>
        .form-control {
            width: 200px;
            height: 40px;
        }

        .discount-circle {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff4500; /* لون أحمر */
            color: white;
            border-radius: 50%; /* لجعل الشكل دائرياً */
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }
    </style>
    <div class="container my-5">
        <div class="bundle-container">
            <div class="row">
                <div class="col-md-5">
                    <div class="bundle-image">
                        @if ($bundle->discount_percentage > 0)
                            <div class="discount-circle">-{{ $bundle->discount_percentage }}%</div>
                        @endif
                        <img src="{{ asset('image/products/' . $bundle->image) }}" alt="{{ $bundle->name_en }}"
                            class="img-fluid" />
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bundle-details text-center">
                        <h2>{{ $bundle->name }}</h2>

                        <p class="features">
                            @if ($bundle->short_description)
                                @foreach (explode("\n", $bundle->short_description) as $feature)
                                    @if (trim($feature) !== '')
                                        &#x2714; {{ trim($feature) }}<br>
                                    @endif
                                @endforeach
                            @else
                                <p>No specific features listed for this bundle.</p>
                            @endif
                        </p>

                        <form method="POST" action="{{ route('cart.add') }}" id="add-to-cart-form" class="w-100 mb-3"
                            style="display: flex; flex-direction: column; align-items: center;">
                            @csrf
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6 col-lg-5 mx-auto">
                                    <label for="period" class="text-center w-100">Period:</label>
                                    <div class="d-flex justify-content-center">
                                        <select id="period" name="duration_price_id"
                                            class="form-control form-control-sm w-auto">
                                            @if ($bundle->durations->isNotEmpty())
                                                @foreach ($bundle->durations->sortBy('duration_in_months') as $duration)
                                                    <option value="{{ $duration->id }}" data-price="{{ $duration->price }}"
                                                        {{ $loop->first ? 'selected' : '' }}>
                                                        {{ $duration->duration_in_months }}
                                                        {{ $duration->duration_in_months == 1 ? 'month' : 'months' }}
                                                        ({{ number_format($duration->price, 2) }}
                                                        @if (App::getLocale() == 'ar')
                                                            جنيه
                                                        @else
                                                            $
                                                        @endif)
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No periods available for this bundle</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

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
                                    @if (Auth::check() &&
                                            Auth::user()->allFavorites()->where('favoritable_id', $bundle->id)->where('favoritable_type', 'App\Models\Bundle')->exists()) fas fa-heart favorited
                                    @else
                                        far fa-heart @endif
                                    "
                                    data-favoritable-id="{{ $bundle->id }}" data-favoritable-type="bundle"></i>
                                Add to Wishlist
                            </span>
                            <div class="share-icons">
                                <span>Share:</span>
                                <a href="https://www.facebook.com/simplysoft.aii"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/simplysoft.ai"><i class="fab fa-instagram"></i></a>
                                <a href="https://wsend.co/201023290446"><i class="fa-brands fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-5" />
            <div class="bundle-description">
                <h2 class="description-title text-center mb-4">Bundle Description</h2>
                <div class="container">

                    @if ($bundle->long_description)
                        {!! nl2br(e($bundle->long_description)) !!}
                    @else
                        <p>No detailed description available for this bundle.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
