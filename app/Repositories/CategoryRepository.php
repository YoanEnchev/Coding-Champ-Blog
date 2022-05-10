<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\TechEntity;
use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public $model = Category::class;

    public function getCategoriesWithTutorialsForTechEntity(TechEntity $techEntity) {

        return $this->model::with(['tutorials' => function($tutorialsQuery) use ($techEntity) {
            $tutorialsQuery
                ->where('tech_entity_id', '=', $techEntity->id)
                ->orderBy('priority');
        }])
        ->orderBy('priority')
        ->get();
    }

    public function hasAnyTutorials(Category $category)
    {
        return $category->tutorials()->count() > 0;
    }
}