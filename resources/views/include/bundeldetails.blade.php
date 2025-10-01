@extends('welcome')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="container {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('language.home') }}</a></li>
                <li><a href="{{ route('shop') }}">{{ __('language.Shop') }}</a></li>
                <li class="divider"></li>
                <li class="current">{{ $bundle->$nameColumn }}</li>
            </ul>
        </div>
    </div>

    <div class="container my-5">
        <div class="row product-page-card rounded-4 p-4">

            {{-- الصور --}}
            <div class="col-lg-5 p-3 d-flex justify-content-center flex-column align-items-center">
                <div class="card product-card border-0 rounded-4 mb-3">
                    @php
                        $firstImage = is_array($bundle->image) && count($bundle->image) > 0 ? $bundle->image[0] : null;
                    @endphp

                    @if ($firstImage)
                        <img src="{{ asset('image/products/' . $firstImage) }}" class="card-img-top rounded-4"
                            alt="{{ $bundle->$nameColumn }}">
                    @else
                        <span class="text-danger">No Image</span>
                    @endif
                </div>
            </div>

            {{-- تفاصيل الباندل --}}
            <div class="col-lg-7 p-3 d-flex flex-column {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
                <div class="d-flex mb-3 des-ti">
                    <h1 class="product-title">{{ $bundle->$nameColumn }}</h1>
                </div>

                {{-- السعر --}}
                <h2 class="product-price" id="current-price">
                    @if ($bundle->durations->isNotEmpty())
                        {{ number_format($bundle->durations->first()->price ?? 0, 2) }}
                        @if ($currentLocale == 'ar')
                            جنيه
                        @else
                            $
                        @endif
                    @else
                        {{ __('language.no_price') }}
                    @endif
                </h2>

                {{-- التقييم (ثابت حالياً) --}}
                <div class="d-flex align-items-center mb-4 start-code">
                    <span class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </span>
                    <span class="ms-2 customer-reviews">1 {{ __('language.customer_review') }}</span>
                </div>

                {{-- الوصف --}}
                <p class="product-description mb-4">
                    {{ $bundle->$shortDescColumn ?? __('language.no_description') }}
                </p>

                {{-- الفورم --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bundle_id" value="{{ $bundle->id }}">

                    <h5 class="duration-title mb-2">{{ __('language.duration') }}</h5>
                    <div class="d-flex duration-options-container flex-wrap mb-4" role="group"
                        aria-label="Duration options">

                        @foreach ($bundle->durations as $duration)
                            <input type="radio" id="duration-{{ $duration->id }}" name="duration_id"
                                value="{{ $duration->id }}" data-price="{{ $duration->price }}" required
                                class="d-none duration-radio" @if ($loop->first) checked @endif>
                            <label for="duration-{{ $duration->id }}"
                                class="btn btn-outline-secondary duration-option @if ($loop->first) active @endif">
                                {{ $duration->duration_in_months }}
                                {{ $duration->duration_in_months == 1 ? __('language.month') : __('language.months') }}
                            </label>
                        @endforeach
                    </div>

                    {{-- الكمية --}}
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

                {{-- بيانات إضافية --}}
                <div class="product-meta mt-4">
                    <p style="color: #000">
                        {{ $bundle->{'long_description_' . app()->getLocale()} ?? __('language.no_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
