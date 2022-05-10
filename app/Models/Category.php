<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['url_name', 'pretty_name', 'priority'];

    public function tutorials()
    {
        return $this->hasMany('App\Models\Tutorial');
    }
}
