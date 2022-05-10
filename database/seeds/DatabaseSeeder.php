<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\TechEntity;
use App\Models\Tutorial;
use App\Models\User;
use App\Models\Tag;
use App\Models\Comment;

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

        // Create admin user:
        factory(User::class)->create([
            'email' => 'admin@admin.com',
            'is_admin' => 1,
            'password' => bcrypt(env('ADMIN_USER_PASSWORD'))
        ]);

        $priority = 1;
        foreach($categoriesData as $categoryData) {
            $categoryData['priority'] = $priority++;
            
            factory(Category::class)->create($categoryData);
        }

        $categories = Category::all();
        $tags = factory(Tag::class, 30)->create();

        $priority = 1;
        $users = factory(User::class, 30)->create();

        foreach($languagesData as $lang => $data) {
            $data['priority'] = $priority++;
            $data['pretty_name'] = $lang;

            $techEntity = factory(TechEntity::class)->create($data);
            $tutorialPriority = 1;
            
            // Can't be accessed via the Storage facade. Probably because it's not inside the storage/app folder.
            foreach(File::allFiles(storage_path() . '/tutorials/' . $data['url_name']) as $file) {
                $fileName = str_replace('.html', '', basename($file)); // remove .html suffix.
                
                $tutorial = factory(Tutorial::class)->create([
                    'tech_entity_id' => $techEntity->id,
                    'category_id' => $categories->random()->id,
                    'url_name' => $fileName,
                    'pretty_name' => ucwords(str_replace('-', ' ', $fileName)),
                    'priority' => $tutorialPriority++
                ]);

                $tutorial->tags()->sync($tags->random(6)->pluck('id')->toArray());

                // Add comments and subcomments.
                $rootComment1 = factory(Comment::class)->create([
                    'tutorial_id' => $tutorial->id,
                    'user_id' => $users->random()->id,
                    'text' => 'Comment Example 1'
                ]);
                $rootComment2 = factory(Comment::class)->create([
                    'tutorial_id' => $tutorial->id,
                    'user_id' => $users->random()->id,
                    'text' => 'Comment Example 2'
                ]);

                $subComment1 = factory(Comment::class)->create([
                    'tutorial_id' => $tutorial->id,
                    'parent_id' => $rootComment1->id,
                    'user_id' => $users->random()->id,
                    'text' => 'Subcomment Example 1'
                ]);
                $subComment2 = factory(Comment::class)->create([
                    'tutorial_id' => $tutorial->id,
                    'parent_id' => $rootComment2->id,
                    'user_id' => $users->random()->id,
                    'text' => 'Subcomment Example 2'
                ]);
                factory(Comment::class)->create([
                    'tutorial_id' => $tutorial->id,
                    'parent_id' => $subComment2->id,
                    'user_id' => $users->random()->id,
                    'text' => 'Sub Subcomment Example'
                ]);
            }
        }
    }
}
