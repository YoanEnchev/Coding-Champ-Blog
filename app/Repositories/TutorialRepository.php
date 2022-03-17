<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Tutorial;
use App\Models\TechEntity;

class TutorialRepository extends BaseRepository
{
    public $model = Tutorial::class;

    public function getTutorialsByTechEntityAndUrlName(TechEntity $techEntity, string $tutorialUrl, array $relations = []) 
    {
        return $techEntity->tutorials()
            ->where('url_name', $tutorialUrl)
            ->with($relations)
            ->first();
    }
}