<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'image'
    ];
    public function products()
{
    return $this->hasMany(Product::class);
}

public function bundles()
{
    return $this->hasMany(Bundle::class);
}
    public function getNameAttribute()
    {
        $locale = App::getLocale();
        return $this->{'name_' . $locale} ?? $this->name_en;
    }
}
