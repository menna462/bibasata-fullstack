<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'password',
        'product_id',
        'bundle_id',
        'duration_price_id',
        'duration_in_days',
        'max_users',
        'current_users',
        'is_full',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
        public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function durationPrice()
{
    return $this->belongsTo(DurationPrice::class);
}
}
