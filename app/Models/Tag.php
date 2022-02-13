<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function tutorials()
    {
        return $this->morphedByMany('App\Tutorial');
    }
}
