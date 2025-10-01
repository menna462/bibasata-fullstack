<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'category_id',
        'name_en',
        'name_ar',
        'image',
        'short_description_en',
        'short_description_ar',
        'long_description_en',
        'long_description_ar',
        'discount_percentage'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // علاقة بين Bundle و Accounts
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
    public function durations()
    {
        return $this->hasMany(DurationPrice::class);
    }
    public function favoritedByUsers()
    {
        return $this->morphToMany(User::class, 'favoritable', 'favorites');
    }
    public function getNameAttribute()
    {
        $locale = App::getLocale();
        return $this->{'name_' . $locale} ?? $this->name_en;
    }

    public function getShortDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{'short_description_' . $locale} ?? $this->short_description_en;
    }

    public function getLongDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{'long_description_' . $locale} ?? $this->long_description_en;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected $casts = [
        'image' => 'array', // 💡 هذا هو الحل. يجب أن يكون نوع الحقل 'array'.
    ];
}
