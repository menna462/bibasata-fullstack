{{-- @extends('welcome')
@section('content') --}}
<!-- swiper -->
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <img src="{{ asset('image/slider/' . $slider->image) }}" alt="" />
                <div class="slide-content">
                    <a href="#" class="call-to-action-button"> BUY NOW </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>


{{-- @endsection --}}
