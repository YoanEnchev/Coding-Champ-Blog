<?php

namespace Tests\Feature;

use App\Models\Tutorial;
use App\Models\User;
use Tests\TestCase;
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
        $response = $this->post(route('admin.swap-priorities', compact('tutorial1', 'tutorial2')));
        $response->assertStatus(403);
        $this->assertEquals($tutorial1, 1);
        $this->assertEquals($tutorial2, 2);
    }
}
