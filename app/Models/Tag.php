<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $fillable = ['pretty_name', 'url_name'];

    public function tutorials()
    {
        return $this->belongsToMany('App\Models\Tutorial', 'tutorial_tag');
    }
}
