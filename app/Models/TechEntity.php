<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechEntity extends Model
{
    public function tutorials()
    {
        return $this->hasMany('App\Tutorial');
    }

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function challenges()
    {
        return $this->hasMany('App\Challenge');
    }
}
