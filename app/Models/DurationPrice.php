<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DurationPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'bundle_id',
        'duration_in_months',
        'price_usd',
        'price_egp'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
    public function getPriceAttribute()
    {
        $locale = App::getLocale();
        if ($locale == 'ar') {
            return $this->price_egp;
        }

        return $this->price_usd;
    }
        public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
