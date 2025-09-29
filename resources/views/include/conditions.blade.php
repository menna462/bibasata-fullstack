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

    {{-- ✅ features --}}
    <div class="row mt-5">
      @foreach(__('language.terms.features') as $feature)
        <div class="col-md-3 col-sm-6 text-center">
          <div class="feature-box">
            <h4>{{ $feature['title'] }}</h4>
            <p>{{ $feature['desc'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

@endsection
