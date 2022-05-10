<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\User;
use App\Models\Tutorial;
use App\Models\TechEntity;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TutorialTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test method about comments hierarchichy.
     *
     * @return void
     */
    public function testGetHierarchicalComments()
    {
        $techEntity = factory(TechEntity::class)->create();
        $category = factory(Category::class)->create();

        $tutorial = factory(Tutorial::class)->create([
            'tech_entity_id' => $techEntity->id,
            'category_id' => $category->id
        ]);
        $users = factory(User::class, 5)->create();
        
        // Insert records:
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
        $subSubComment = factory(Comment::class)->create([
            'tutorial_id' => $tutorial->id,
            'parent_id' => $subComment2->id,
            'user_id' => $users->random()->id,
            'text' => 'Sub Subcomment Example'
        ]);


        $allComments = Comment::all();
        $hierarchicalComments = $tutorial->getHierarchicalComments();
        
        // Root comments:
        $this->assertTrue($hierarchicalComments->contains($rootComment1->id));
        $this->assertTrue($hierarchicalComments->contains($rootComment2->id));
        $this->assertEquals(2, $hierarchicalComments->count());

        // Subcomments:        
        $root1Subcomments = $hierarchicalComments->get(0)->subcomments;
        $this->assertEquals(1, count($root1Subcomments));
        $this->assertEquals($subComment1->id, $root1Subcomments[0]->id);

        $root2Subcomments = $hierarchicalComments->get(1)->subcomments;
        $this->assertEquals(1, count($root2Subcomments));
        $this->assertEquals($subComment2->id, $root2Subcomments[0]->id);
        
        // Sub Subcomments:
        $subComment1Comments = $root1Subcomments[0]->subcomments;
        $this->assertEquals(0, count($subComment1Comments));

        $subComment2Comments = $root2Subcomments[0]->subcomments;
        $this->assertEquals(1, count($subComment2Comments));
        $this->assertEquals($subSubComment->id, $subComment2Comments[0]->id);
    }
}
