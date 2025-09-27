@extends('index')
@section('content')
    <!-- start about -->
    <div class="container custom-container mb-5 mt-3">
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <img src={{ asset('frontend/images/about.png') }} alt="Office" class="img-fluid rounded hanging-chair">
            </div>
            <div class="col-md-6 flex-column mt-3">
                <h5 class="text-danger">{{ __('language.about.revolutionizing_graphic_stock') }}</h5>
                <h2 class="fw-bold">{{ __('language.about.intro_title') }}</h2>
                <p>{{ __('language.about.intro_text') }}</p>
                <h2 class="fw-bold">{{ __('language.about.why_title') }}</h2>
                <p>{{ __('language.about.why_text_one') }}
                    <br>
                    {{ __('language.about.why_text_two') }}</p>
                <h2 class="fw-bold">{{ __('language.about.store_title') }}</h2>
                <p>{{ __('language.about.store_text_one') }}
                    <br>
                    {{ __('language.about.store_text_two') }}
                    <br>
                    {{ __('language.about.store_text_three') }}</p>
                <hr>
                <div class="socials-icons text-center ">
                    <a href="https://www.facebook.com/BibasataSoftAi"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/bibasatasoftai"><i class="fab fa-instagram"></i></a>
                    <a href="https://wsend.co/201023290446"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- end about -->
@endsection
