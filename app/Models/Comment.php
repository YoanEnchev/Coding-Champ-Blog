<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tutorial;

class Comment extends Model
{
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

    public function attachSubcommentsHelper(object $allCommentsCollection) : void
    {
        $this->subcomments = $allCommentsCollection->where('parent_id', $this->id);

        foreach ($this->subcomments as $comment) {

            $comment->attachSubcommentsHelper($allCommentsCollection);
        }
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }
}
