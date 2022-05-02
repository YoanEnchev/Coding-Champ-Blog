<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Comment;
use App\Models\Tutorial;

class CommentRepository extends BaseRepository
{
    public $model = Comment::class;
}