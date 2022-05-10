<?php

namespace Tests\Unit\Helpers;

use App\Models\Tag;
use App\Helpers\TagsHelper;
use App\Repositories\TagRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagHelperTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test what tags are created and returned.
     *
     * @return void
     */
    public function testGetTagsIdsFromText()
    {
        $tagA = factory(Tag::class)->create([
            'url_name' => 'a', 'pretty_name' => 'A'
        ]);
        $tagB = factory(Tag::class)->create([
            'url_name' => 'b', 'pretty_name' => 'B'
        ]);
        // Tag C must be created by the method itself.
        $tagD = factory(Tag::class)->create([
            'url_name' => 'd', 'pretty_name' => 'D'
        ]);

        $this->assertEquals(Tag::count(), 3);
        $result = TagsHelper::getTagsIdsFromText('A, B, C, D', new TagRepository());
        $this->assertEquals(Tag::count(), 4); // A new tag has been created.

        // Make sure ids of the products with requested names are returned.
        $this->assertTrue($result === [$tagA->id, $tagB->id, 4, $tagD->id]);
    }
}
