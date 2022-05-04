<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    public $model = Comment::class;
}