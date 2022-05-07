<?php

namespace App\Helpers;

use App\Helpers\NameHelper;
use App\Repositories\TagRepository;

class TagsHelper
{
    public static function getTagsAsText(object $tagsCollection) : string
    {
        return implode(', ', $tagsCollection->pluck('pretty_name')->toArray());
    }

    // $tagsText is string like "tag 1, tag 2, tag 3...".
    public static function getTagsIdsFromText(string $tagsText, TagRepository $tagRepo) : array
    {
        $tagIds = [];
                
        foreach(explode(', ', $tagsText) as $tagText) {
            // Extract existing tag by name or create such if doesn't exist:
            $tag = $tagRepo->getTagByPrettyName($tagText);

            if($tag === null) {
                
                $tag = $tagRepo->create([
                    'pretty_name' => $tagText,
                    'url_name' => NameHelper::makeNameUrlFriendly($tagText)
                ]);
            }

            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }
}