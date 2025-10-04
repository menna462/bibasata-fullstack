<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

if (! function_exists('format_price')) {
    function format_price($durationOrValue)
    {
        $currency = Session::get('user_currency', 'EGP');
        $symbol = $currency === 'EGP' ? 'ج.م ' : '$';
        $price = null;

        if (is_object($durationOrValue)) {
            $price = $currency === 'EGP' ? ($durationOrValue->price_egp ?? null) : ($durationOrValue->price_usd ?? null);
        } elseif (is_array($durationOrValue)) {
            $price = $currency === 'EGP' ? ($durationOrValue['price_egp'] ?? null) : ($durationOrValue['price_usd'] ?? null);
        } elseif (is_numeric($durationOrValue)) {
            $price = $durationOrValue;
        }

        Log::info('Currency from session: ' . $currency);
        Log::info('Price value: ' . json_encode($price));
        Log::info('Full duration object/array: ' . json_encode($durationOrValue));
        if (is_array($price)) {
            Log::error('❌ format_price error: $price is array', ['value' => $price, 'input' => $durationOrValue]);
            return 'Invalid price';
        }
        if (!is_numeric($price)) {
            return __('language.no_price');
        }

        return $symbol . number_format($price, 2);
    }
}
