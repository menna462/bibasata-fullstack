<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    protected $table = 'favorites';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function favoritable()
    {
        return $this->morphTo();
    }
}
