<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\TechEntity;
use App\Models\Tutorial;
use App\Models\User;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $languagesData = [
            // Ordered by priority.
            'Python' => [
                'cm_mode' => 'text/x-python',
                'url_name' => 'python'
            ],
            'Java' => [
                'cm_mode' => 'text/x-java',
                'url_name' => 'java'
            ],
            'JavaScript' => [
                'cm_mode' => 'text/javascript',
                'url_name' => 'javascript'
            ],
            'C++' =>  [
                'cm_mode' => 'text/x-c++src',
                'url_name' => 'c-plus-plus'
            ],
            'C#' => [
                'cm_mode' => 'text/x-csharp',
                'url_name' => 'c-sharp'
            ],
            'PHP' => [
                'cm_mode' => 'text/x-php',
                'url_name' => 'php'
            ],
        ];

        $categoriesData = [
            ['url_name' => 'basics', 'pretty_name' => 'Basics'],
            ['url_name' => 'advanced', 'pretty_name' => 'Advanced'],
            ['url_name' => 'oop', 'pretty_name' => 'OOP']
        ];

        $priority = 1;
        foreach($categoriesData as $categoryData) {
            $categoryData['priority'] = $priority++;
            
            factory(Category::class)->create($categoryData);
        }

        $categories = Category::all();
        $tags = factory(Tag::class, 30)->create();

        $priority = 1;
        foreach($languagesData as $lang => $data) {
            $data['priority'] = $priority++;
            $data['pretty_name'] = $lang;

            $techEntity = factory(TechEntity::class)->create($data);
            
            // Can't be accessed via the Storage facade. Probably because it's not inside the storage/app folder.
            foreach(File::allFiles(storage_path() . '/tutorials/' . $data['url_name']) as $file) {
                $fileName = str_replace('.html', '', basename($file)); // remove .html suffix.
                
                $tutorial = factory(Tutorial::class)->create([
                    'tech_entity_id' => $techEntity->id,
                    'category_id' => $categories->random()->id,
                    'url_name' => $fileName,
                    'pretty_name' => ucwords(str_replace('-', ' ', $fileName))
                ]);

                $tutorial->tags()->sync($tags->random(6)->pluck('id')->toArray());
            }
        }

        factory(User::class)->create([
            'email' => 'admin@admin.com',
            'is_admin' => 1
        ]);
    }

    public function removeDotPaths($pathsArr)
    {
        $cleanned = array_diff($pathsArr, ['.', '..']);

        // Reindex array
        return array_values($cleanned);
    }
}
