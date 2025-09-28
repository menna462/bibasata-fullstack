@extends('welcome')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body">
                    <h1 class="card-title text-center text-primary mb-4">{{ __('language.page_title') }}</h1>

                    @if(session('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">{{ __('language.error_heading') }}</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h2 class="h5 text-primary mb-3 text-center">{{ __('language.edit_account_details_heading') }}</h2>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('language.name_label') }}:</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('language.email_label') }}:</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="form-label">{{ __('language.phone_label') }}:</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" class="form-control @error('phone_number') is-invalid @enderror">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-50">{{ __('language.update_button') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body">
                    <h2 class="h5 text-primary mb-3 text-center">{{ __('language.change_password_heading') }}</h2>
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('language.current_password_label') }}:</label>
                            <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('language.new_password_label') }}:</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">{{ __('language.confirm_password_label') }}:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary w-50">{{ __('language.change_password_button') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center mb-4">
            <h2 class="text-primary">{{ __('language.purchased_products_heading') }}</h2>
        </div>
        @forelse($confirmedOrders as $order)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        @php
                            $item = $order->product ?? $order->bundle;
                        @endphp

                        @if($item)
                            @if(isset($item->image))
                                <img src="{{ asset('image/products/' . $item->image) }}" class="img-fluid rounded mb-3" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $item->name }}">
                            @else
                                <p class="text-muted">{{ __('language.no_image') }}</p>
                            @endif
                            <h5 class="card-title text-dark">{{ $item->name }}</h5>
                            <p class="card-text text-muted"><strong>{{ __('language.price_label') }}:</strong> {{ $order->duration_price_id }} {{ __('language.currency') }}</p>
                            <p class="card-text text-muted"><strong>{{ __('language.purchase_date_label') }}:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">{{ __('language.no_purchased_products') }}</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .text-primary {
        color: #0d6efd !important; /* Bootstrap primary color */
    }
    .text-secondary {
        color: #6c757d !important;
    }
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .img-fluid {
        border: 1px solid #ddd;
        padding: 3px;
    }
</style>
@endsection
