<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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
        return $this->belongsTo('App\Models\TechEntity');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'tutorial_tag');
    }

    public function getFilePathAttribute()
    {
        return storage_path('tutorials/' . $techEntityUrl . '/' . $tutorialUrl . '.html');
    }

    public function getContentAttribute()
    {
        return File::get($this->file_path);
    }
}
