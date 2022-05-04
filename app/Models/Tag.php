<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    public function tutorials()
    {
        return $this->belongsToMany('App\Models\Tutorial', 'tutorial_tag');
    }
}
