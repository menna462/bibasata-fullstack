@extends('welcome')

@section('content')
    <div class="shop">
        <div class="shop-contan">
            <h1>{{ __('language.cart_title') }}</h1>
            <p>
                <a href="{{ url('/') }}">{{ __('language.home') }}</a>
                <span><i class="fas fa-chevron-left"></i></span>
                {{ __('language.cart_title') }}
            </p>
        </div>
    </div>

    <div class="page-container" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="main-content ">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th class="product-header">{{ __('language.product') }}</th>
                        <th class="price-header">{{ __('language.price') }}</th>
                        <th class="quantity-header">{{ __('language.quantity') }}</th>
                        <th class="subtotal-header">{{ __('language.subtotal') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formattedCartItems as $item)
                        <tr>
                            <td class="product-cell" data-label="{{ __('language.product') }}">
                                <div class="product-info-details">
                                    <img src="{{ asset('image/products/' . $item['image']) }}"
                                         alt="product image"
                                         class="product-image" />
                                    <span class="product-name">{{ $item['name_en'] }}</span>
                                </div>
                            </td>
                            <td class="price-cell" data-label="{{ __('language.price') }}">
                                ${{ number_format($item['price_usd'], 2) }}
                            </td>
                            <td class="quantity-cell" data-label="{{ __('language.quantity') }}">
                                <form action="{{ route('cart.update', $item['duration_price_id']) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number"
                                           class="quantity-box"
                                           name="quantity"
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           onchange="this.form.submit()" />
                                </form>
                            </td>
                            <td class="subtotal-cell" data-label="{{ __('language.subtotal') }}">
                                ${{ number_format($item['total_price_usd'], 2) }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item['duration_price_id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        {{ __('language.remove') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                {{ __('language.empty_cart') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="cart-totals-container">
                <h3 class="totals-title">{{ __('language.cart_totals') }}</h3>
                <div class="total-row">
                    <span class="total-label">{{ __('language.subtotal') }}</span>
                    <span class="total-value">${{ number_format($cartTotal, 2) }}</span>
                </div>
                <div class="total-row total-amount">
                    <span class="total-label">{{ __('language.total') }}</span>
                    <span class="total-value">${{ number_format($cartTotal, 2) }}</span>
                </div>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="checkout-button">
                        {{ __('language.checkout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
