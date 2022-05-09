<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechEntity extends Model
{
    public $timestamps = false;

    protected $fillable = ['url_name', 'pretty_name', 'cm_mode', 'priority'];

    public function tutorials()
    {
        return $this->hasMany('App\Models\Tutorial');
    }
}
