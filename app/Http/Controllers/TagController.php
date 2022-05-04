<?php

namespace App\Http\Controllers;

use App\Repositories\TechEntityRepository;
use App\Repositories\TagRepository;

class TagController extends Controller {

    public function __construct(TechEntityRepository $techEntityRepo, TagRepository $tagRepo) 
    {
        $this->techEntityRepo = $techEntityRepo;
        $this->tagRepo = $tagRepo;
    }

    public function show(string $techEntityUrl, string $tagUrlName)
    {
        $techEntities = $this->techEntityRepo->getAll();

        $techEntity = $this->techEntityRepo->getByUrlName($techEntityUrl);
        if($techEntity === null) abort(400);

        $tag = $this->tagRepo->getTagByUrlName($tagUrlName, ['tutorials']);
        if($tag === null) return abort(400);
        
        $tutorials = $this->tagRepo->getTutorialsForTagAndTechEntity($tag, $techEntity);

        return view('tags.show', compact('techEntities', 'techEntity', 'tag', 'tutorials'));
    }
}