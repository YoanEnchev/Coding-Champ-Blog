<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class Tutorial extends Model
{
    use RoutesWithFakeIds;
    public $timestamps = false;

    protected $fillable = ['tech_entity_id', 'category_id', 'pretty_name', 'url_name', 'keywords', 'description', 'priority'];

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

    // Flat collection of comments
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    // Extract Hierarchy of comments without unnecessary DB requests.
    //
    // Comment 1
    //   Comment 2
    //   Comment 3
    //      Comment 5
    // Comment 4
    public function getHierarchicalComments()
    {
        $allComments = $this->comments()
            ->with('user')
            ->get();
        
        $orphanedComments = $allComments
            ->filter(fn(Comment $comment) => $comment->isOrphaned());

        // Attach subcomments attribute:
        $orphanedComments->map(function(Comment $comment) use($allComments) {
            $comment->attachSubcommentsHelper($allComments);
        });

        return $orphanedComments;
    }

    public function getFilePathAttribute()
    {
        return storage_path('tutorials/' . $this->techEntity->url_name . '/' . $this->url_name . '.html');
    }

    public function getContentAttribute()
    {
        return File::get($this->file_path);
    }
}
