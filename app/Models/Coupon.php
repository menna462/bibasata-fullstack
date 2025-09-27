<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
        protected $fillable = [
            'code',
            'discount_percentage',
            'is_active',
            'usage_limit',
            'expiry_date',
        ];
            protected $casts = [
        'is_active'   => 'boolean',
        'expiry_date' => 'datetime', // أضف هذا السطر
    ];
}
