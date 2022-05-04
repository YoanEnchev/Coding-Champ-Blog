<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public $model = User::class;

    public function findByEmail(string $email) : ?User
    {
        return $this->model::where('email', $email)->first();
    }

    public function findByUsername(string $username) : ?User
    {
        return $this->model::where('username', $username)->first();
    }
}