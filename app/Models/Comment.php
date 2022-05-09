<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tutorial;

class Comment extends Model
{
    protected $fillable = ['tutorial_id', 'user_id', 'parent_id', 'text'];

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOrphaned() : bool
    {
        return !isset($this->parent_id);
    }

    public function attachHelpingAttributes(object $allCommentsCollection) : void
    {
        $subcommentsCollection = $allCommentsCollection->where('parent_id', $this->id);
        
        // Reindex array so it'parsed as array instead of JSON object when it's passed to JS:
        $this->subcomments = [...$subcommentsCollection];
       
        $this->date = $this->created_at_formatted;

        foreach ($subcommentsCollection as $comment) {

            $comment->attachHelpingAttributes($allCommentsCollection);
        }
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }
}
