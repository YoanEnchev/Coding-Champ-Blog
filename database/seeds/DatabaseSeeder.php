<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\TechEntity;
use Illuminate\Support\Facades\File;
use App\Helpers\Converter;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Maybe it's neseccary to use something else.
        $cmModes = [
            'C++' => 'text/x-c++src',
            'Java' => 'text/x-java',
            'C#' => 'text/x-csharp',
            'PHP' => 'text/x-php',
            'JS' => 'text/javascrip'
        ];

        $tutorialsPath = storage_path() . '/tutorials';
        
        // Languages:
        $techEntitiesDir = scandir($tutorialsPath);
        $techEntities = $this->removeDotPaths($techEntitiesDir);
        
        $techEntityData = array_map(function($prettyName) use($cmModes) {
            return [
                'pretty_name' => $prettyName,
                'url_name' => Converter::makeWordUrlFriendly($prettyName),
                'cm_mode' => $cmModes[$prettyName]
            ];
        }, $techEntities);
        TechEntity::insert($techEntityData);

        $categoriesDirs = scandir($tutorialsPath . '/' . $techEntities[0]);
        $categoriesDirs = $this->removeDotPaths($categoriesDirs);
        
        $categoriesData = array_map(function($catName) {
            return [
                'pretty_name' => $catName,
                'url_name' => Converter::makeWordUrlFriendly($catName)
            ];
        }, $categoriesDirs);
        Category::insert($categoriesData);
    }

    public function removeDotPaths($pathsArr)
    {
        $cleanned = array_diff($pathsArr, ['.', '..']);

        // Reindex array
        return array_values($cleanned);
    }
}
