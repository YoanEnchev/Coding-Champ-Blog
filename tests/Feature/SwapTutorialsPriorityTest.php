<?php

namespace Tests\Feature;

use App\Models\Tutorial;
use App\Models\User;
use App\Models\TechEntity;
use App\Models\Category;
use Tests\TestCase;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SwapTutorialsPriorityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test priority swapping.
     *
     * @return void
     */
    public function testPrioritySwapping()
    {
        $techEntity = factory(TechEntity::class)->create();
        $category = factory(Category::class)->create();

        $tutorial1 = factory(Tutorial::class)->create([
            'tech_entity_id' => $techEntity->id,
            'category_id' => $category->id,
            'priority' => 1
        ]);

        $tutorial2 = factory(Tutorial::class)->create([
            'tech_entity_id' => $techEntity->id,
            'category_id' => $category->id,
            'priority' => 2
        ]);

        $nonAdminUser = factory(User::class)->create();
        $adminUser = factory(User::class)->create(['is_admin' => true]);


        // If no user is logged in - unsuccessful swap.
        $response = $this->post(route('admin.tutorial.swap-priorities', compact('tutorial1', 'tutorial2')));
        $response->assertStatus(302);
        $this->assertEquals(1, Tutorial::find($tutorial1->id)->priority);
        $this->assertEquals(2, Tutorial::find($tutorial2->id)->priority);


        // If non admin user is logged in - unsuccessful swap.
        Auth::login($nonAdminUser);
        $response = $this->post(route('admin.tutorial.swap-priorities', compact('tutorial1', 'tutorial2')));
        $response->assertStatus(302);
        $this->assertEquals(1, Tutorial::find($tutorial1->id)->priority);
        $this->assertEquals(2, Tutorial::find($tutorial2->id)->priority);


        // If admin user is logged in - successful swap.
        Auth::login($adminUser);
        $response = $this->post(route('admin.tutorial.swap-priorities', compact('tutorial1', 'tutorial2')));
        $response->assertStatus(200);
        $this->assertEquals(2, Tutorial::find($tutorial1->id)->priority);
        $this->assertEquals(1, Tutorial::find($tutorial2->id)->priority);
    }
}
