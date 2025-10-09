@extends('welcome')

@section('content')

<div class="shop">
  <div class="shop-contan">
    <h1>{{ __('language.terms.title') }}</h1>
    <p>
      {{ __('language.terms.breadcrumb') }}
      <span><i class="fas fa-chevron-left"></i></span>
      {{ __('language.terms.title') }}
    </p>
  </div>
</div>

<div class="about-us-section py-5 {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 class="red-title">{{ __('language.terms.title') }}</h3>
        <h2 class="section-title">{{ __('language.terms.welcome') }}</h2>
        <p class="section-description">{{ __('language.terms.intro') }}</p>
      </div>
    </div>

    {{-- ✅ sections --}}
    @php
      $sections = __('language.terms.sections');
    @endphp

    @foreach($sections as $section)
      <div class="row mt-4">
        <div class="col-12">
          <h3 class="section-title">{{ $section['title'] }}</h3>

          {{-- لو فيه قائمة --}}
          @if(isset($section['list']))
            <ul class="section-description">
              @foreach($section['list'] as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          @endif

          {{-- لو فيه نص عادي --}}
          @if(isset($section['text']))
            <p class="section-description">{{ $section['text'] }}</p>
          @endif
        </div>
      </div>
    @endforeach


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
@endsection
