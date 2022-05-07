<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Tag;
use App\Models\TechEntity;
use App\Models\Tutorial;

class TagRepository extends BaseRepository
{
    public $model = Tag::class;

    public function getTagsForTutorial(Tutorial $tutorial)
    {
        return $tutorial->tags;
    }

    public function getTagByUrlName(string $urlName, array $eager = [])
    {
        return Tag::where('url_name', $urlName)
            ->with($eager)
            ->first();
    }

    public function getTagByPrettyName(string $prettyName, array $eager = [])
    {
        return Tag::where('pretty_name', $prettyName)
            ->with($eager)
            ->first();
    }

    // Make sure tutorials are eager loaded for tag before calling this function.
    // This way one DB request is saved.
    public function getTutorialsForTagAndTechEntity(Tag $tag, TechEntity $techEntity)
    {
        return $tag->tutorials->where('tech_entity_id', $techEntity->id);
    }

    public function clearUnusedTags() : void
    {
        $this->model::doesnthave('tutorials')->delete();
    }
}