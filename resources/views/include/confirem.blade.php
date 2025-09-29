@extends('welcome')

@section('content')

    <div class="confirem">
        <h1>{{ __('language.subscription_confirmed') }}</h1>
        <img src="{{ asset('frontend/image/check1.png') }}" alt="علامة صح" />
        <p>
            {{ __('language.thank_you_message') }}
        </p>
        <a href="{{ url('/') }}">
            <button>{{ __('language.back_to_home') }}</button>
        </a>
    </div>
@endsection
