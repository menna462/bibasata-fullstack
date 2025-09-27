<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'image',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'long_description_en',
        'long_description_ar',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function account()
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

    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{'description_' . $locale} ?? $this->description_en;
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
}
