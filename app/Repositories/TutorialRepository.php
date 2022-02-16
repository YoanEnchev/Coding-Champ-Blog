<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Tutorial;

class TutorialRepository extends BaseRepository
{
    public $model = Tutorial::class;

    public function getTutorialsByTechEntityAndUrlName(TechEntity $techEntity, string $techEntityUrl) 
    {
        return $techEntity->tutorials()->where('url_name', $techEntityUrl)->first();
    }
}