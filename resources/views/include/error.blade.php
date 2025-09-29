<!DOCTYPE html>
{{-- <html lang="en"> --}}

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <title>error</title>
</head>

<body class="error">
    <div class="body-error">
        <img src="{{ asset('frontend/image/logo1.png') }}"  alt="" srcset="" />
        <h4>{{ __('language.maintenance_title') }}</h4>
        <p>
            {{ __('language.maintenance_message') }}
            </p>
        </div>

    <button type="submit" class="checkout-button">
        {{ __('language.checkout') }}
        </button>

</body>

</html>
