<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\TechEntity;
use App\Models\Tutorial;

class TechEntityRepository extends BaseRepository
{
    public $model = TechEntity::class;

    public function getByUrlName(string $techEntityUrl) 
    {
        return $this->model::where('url_name', $techEntityUrl)->first();
    }

    public function getTutorials(TechEntity $techEntity)
    {
        // Sort by 2 criterias (category priority and tutorial priority).
        return Tutorial::with(['category' => function($categoriesQuery) use ($techEntity) {
            $categoriesQuery->orderBy('priority');
        }])
        ->orderBy('priority')
        ->get();
    }
}