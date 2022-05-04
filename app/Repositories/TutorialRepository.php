<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Tutorial;
use App\Models\TechEntity;
use App\Models\Category;

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

    public function getMaxPriority($techEntityId, $categoryId)
    {
        return $this->model::where([
            ['tech_entity_id', '=', $techEntityId],
            ['category_id', '=', $categoryId]
        ])->max('priority') + 1;
    }

    public function getTutorialsInTechEntityAndCat(TechEntity $techEntity, Category $category)
    {
        return $this->model::where([
            ['tech_entity_id', '=', $techEntity->id],
            ['category_id', '=', $category->id]
        ])
        ->orderBy('priority')
        ->get();
    }
}