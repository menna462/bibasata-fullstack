@extends('welcome')
@section('content')
<!-- start about -->
<div class="shop {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
  <div class="shop-contan">
    <h1>{{ __('language.page_title') }}</h1>
    <p>
      {{ __('language.breadcrumb_home') }}
      <span><i class="fas fa-chevron-left"></i></span>
      {{ __('language.breadcrumb_about') }}
    </p>
  </div>
</div>

<div class="about-us-section py-5 {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
  <div class="container">
    <!-- Introduction -->
    <div class="row">
      <div class="col-12">
        <h3 class="red-title">{{ __('language.about_title') }}</h3>
        <h2 class="section-title">{{ __('language.about_subtitle') }}</h2>
        <p class="section-description">
          {{ __('language.about_text') }}
        </p>
      </div>
    </div>

    <!-- Mission -->
    <div class="row mt-4">
      <div class="col-12">
        <h3 class="section-title">{{ __('language.mission_title') }}</h3>
        <p class="section-description">
          {{ __('language.mission_text') }}
        </p>
      </div>
    </div>

    <!-- Values -->
    <div class="row mt-4">
      <div class="col-12">
        <h3 class="section-title">{{ __('language.values_title') }}</h3>
        <ul class="section-description">
          <li>{{ __('language.values.transparency') }}</li>
          <li>{{ __('language.values.security') }}</li>
          <li>{{ __('language.values.satisfaction') }}</li>
          <li>{{ __('language.values.commitment') }}</li>
          <li>{{ __('language.values.innovation') }}</li>
        </ul>
      </div>
    </div>

    <!-- Why Choose Us -->
    <div class="row mt-4">
      <div class="col-12">
        <h3 class="section-title">{{ __('language.why_title') }}</h3>
        <ul class="section-description">
          <li>{{ __('language.why.discounts') }}</li>
          <li>{{ __('language.why.guarantee') }}</li>
          <li>{{ __('language.why.customers') }}</li>
          <li>{{ __('language.why.support') }}</li>
          <li>{{ __('language.why.experience') }}</li>
        </ul>
      </div>
    </div>

    <!-- Vision -->
    <div class="row mt-4">
      <div class="col-12">
        <h3 class="section-title">{{ __('language.vision_title') }}</h3>
        <p class="section-description">
          {{ __('language.vision_text') }}
        </p>
      </div>
    </div>
  </div>
</div>

<div class="green-line">
  <div class="container-fluid">
    <div class="row gx-0">
      <div class="col-lg-3 col-md-6 col-6 part">
        <div class="img-inderline">
          <img src="{{ asset('frontend/image/trophy.png') }}" alt="Trophy icon" />
        </div>
        <div>
          <h5>{{ __('language.features.quality.title') }}</h5>
          <p>{{ __('language.features.quality.desc') }}</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-6 part">
        <div class="img-inderline">
          <img src="{{ asset('frontend/image/Vector1.png') }}" alt="Warranty icon" />
        </div>
        <div>
          <h5>{{ __('language.features.warranty.title') }}</h5>
          <p>{{ __('language.features.warranty.desc') }}</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-6 part">
        <div class="img-inderline">
          <img src="{{ asset('frontend/image/Vector2.png') }}" alt="Exclusive deals icon" />
        </div>
        <div>
          <h5>{{ __('language.features.deals.title') }}</h5>
          <p>{{ __('language.features.deals.desc') }}</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-6 part">
        <div class="img-inderline">
          <img src="{{ asset('frontend/image/Vector3.png') }}" alt="Support icon" />
        </div>
        <div>
          <h5>{{ __('language.features.support.title') }}</h5>
          <p>{{ __('language.features.support.desc') }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end about -->

@endsection
