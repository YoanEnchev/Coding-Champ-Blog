<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class Tutorial extends Model
{
    use RoutesWithFakeIds;
    public $timestamps = false;

    public function jsonSerialize()
    {
        return [
            'id' => $this->fake_id,
            'pretty_name' => $this->pretty_name,
        ];
    }

    // Needed for access to the fake ID.
    public function getFakeIdAttribute()
    {
        return $this->getRouteKey();
    }

    public function techEntity()
    {
        return $this->belongsTo('App\TechEntity');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function puzzles()
    {
        return $this->hasMany('App\Puzzle');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag');
    }

    
    public function getUrlAttribute()
    {
        // TODO: handle names like "Class Inheritance - Part 1"
        return str_replace('-', '', strtolower($this->name));
    }
}
