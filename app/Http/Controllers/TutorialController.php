<?php

namespace App\Http\Controllers;

use App\Models\TechEntity;
use App\Models\Tutorial;
use App\Models\Category;
use App\Repositories\TechEntityRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TutorialRepository;
use Illuminate\Http\Request;
use \DB;
use Illuminate\Support\Facades\File;

class TutorialController extends Controller
{

    public function __construct(TechEntityRepository $techEntityRepo, CategoryRepository $categoryRepo, TutorialRepository $tutorialRepo) 
    {
        $this->techEntityRepo = $techEntityRepo;
        $this->categoryRepo = $categoryRepo;
        $this->tutorialRepo = $tutorialRepo;
    }

    public function create()
    {
        $categories = $this->categoryRepo->getAll();
        $techEntities = $this->techEntityRepo->getAll();

        return view('tutorial.create', compact('categories', 'techEntities'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'tech_entity_id' => 'required | numeric',
            'category_id' => 'required | numeric',
            'name' => 'required | string'
        ]);

        $message = 'Added tutorial successfully.';
        $status = 'success';

        try {
            DB::transaction(function ($data) use ($request) {
                $name = $request->name;

                // So tutorial is listed as last.
                $this->tutorialRepo->create([
                    'tech_entity_id' => $request->tech_entity_id,
                    'category_id' => $request->category_id,
                    'url_name' => Converter::makeWordUrlFriendly($name),
                    'pretty_name' => $name,
                    'priority' => $this->tutorialRepo->getMaxPriority() + 1,
                    'keywords' => ""
                ]);
            });
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = 'error';
        }
        
        return redirect()->back()->with([$status => $message]);
    }

    // Listing accessed by everyone:
    public function index(string $techEntityUrl)
    {

        $techEntity = $this->techEntityRepo->getByUrlName($techEntityUrl);
        if($techEntity === null) abort(400);

        $categories = $this->categoryRepo->getCategoriesWithTutorialsForTechEntity($techEntity);
        $techEntities = $this->techEntityRepo->getAll();
        $noScroll = true;

        // For SEO purposes
        $language = $techEntity->pretty_name;
        $title = $language . ' Tutorials';
        $description = 'Simplified tutorials for ' . $language . '. Learn if statements, loops, arrays, data structures, functions, classes, object oriented programming (OOP) and much more.';

        return view('tutorial.index', compact('categories', 'techEntity', 'techEntities', 'noScroll', 'title', 'description'));
    }

    public function listInAdminPanel(TechEntity $techEntity)
    {

        $categories = $this->categoryRepo->getCategoriesWithTutorialsForTechEntity($techEntity);
        $techEntities = $this->techEntityRepo->getAll();

        $selectedTechEntity = $techEntity;

        return view('tutorial.listing', compact('categories', 'techEntities', 'selectedTechEntity'));
    }

    public function show(string $techEntityUrl, string $tutorialUrl)
    {
        
        $techEntity = $this->techEntityRepo->getByUrlName($techEntityUrl);
        if($techEntity === null) abort(400);

        $tutorials = $this->techEntityRepo->getTutorials($techEntity); // Shown in side navigation.
        $tutorial = $this->tutorialRepo->getTutorialsByTechEntityAndUrlName($techEntity, $tutorialUrl, ['techEntity']);
        $comments = $tutorial->getHierarchicalComments();

        $techEntities = $this->techEntityRepo->getAll();

        if($tutorial === null || !File::exists($tutorial->filePath)) abort(400);
        $title = $techEntity->pretty_name . ' - ' . $tutorial->pretty_name;

        $cmMode = $techEntity->cm_mode;

        return view('tutorial.show', compact('techEntity', 'techEntities', 'tutorial', 'tutorials', 'comments', 'title', 'cmMode'));
    }

    // Accessed via ajax
    public function getTutorialsInTechEntityAndCat(TechEntity $techEntity, Category $category)
    {
        $tutorials = $this->tutorialRepo->getTutorialsInTechEntityAndCat($techEntity, $category);

        return response()->json($tutorials, 200);
    }

    public function priorityListing()
    {
        
        $techEntities = $this->techEntityRepo->getAll();
        $categories = $this->categoryRepo->getAll();

        return view('tutorial.priority-listing', compact('techEntities', 'categories'));
    }

    public function edit(Tutorial $tutorial)
    {

        $puzzles = $tutorial->puzzles;
        $questions = $tutorial->questions;
        $category = $tutorial->category->pretty_name;
        
        $puzzlesCount = $puzzles->count();
        $questionsCount = $questions->count();
        $techEntities = $this->techEntityRepo->getAll();
        

        $techEntity = $tutorial->techEntity;
        $puzzlesWordsCategories = [
            'operators' => 'Operators',
            'values' => 'Values',
            'variables_constants' => 'Variables / Constants',
            'others' => 'Others'
        ];

        $cmMode = $techEntity->cm_mode;

        return view('tutorial.edit',  compact('tutorial', 'puzzles',
        'questions', 'puzzlesCount', 'questionsCount', 'techEntity', 'techEntities', 
        'puzzlesWordsCategories', 'category', 'cmMode'));
    }

    public function update(Tutorial $tutorial, Request $request)
    {

        $request->validate([
            'pretty_name' => 'required | string',
            'url_name' => 'required | string',
        ]);

        $message = 'Updated tutorial names successfully.';
        $status = 'success';

        $urlName = $request->url_name;;

        try {

            $tutorialOldUrl = $tutorial->url_name;
            $keywords = $request->keywords;
            $description = $request->description;

            DB::transaction(function () use($request, $tutorial, $urlName, $keywords, $description) {
                
                $updateData = [
                    'url_name' => $urlName,
                    'pretty_name' => $request->pretty_name
                ];
                
                if($keywords && is_string($keywords)) $updateData['keywords'] = $keywords;
                if($description && is_string($description)) $updateData['description'] = $description;

                $this->tutorialRepo->updateInstance($tutorial, $updateData);
            });

            $techEntityUrl = $tutorial->techEntity->url_name;

            File::move(storage_path('tutorials/' . $techEntityUrl . '/' . $tutorialOldUrl . '.html'),
                storage_path('tutorials/' . $techEntityUrl . '/' . $urlName . '.html'));

        } catch (\Exception $e) {
            $message = 'Invalid data for names.';
            $status = 'error';
        }

        return redirect()->back()->with([$status => $message]);
    }

    public function swapPriorities(Tutorial $tutorial1, Tutorial $tutorial2)
    {
        
        $p1 = $tutorial1->priority;
        $p2 = $tutorial2->priority;

        $tutorial1->priority = $p2;
        $tutorial2->priority = $p1;

        $tutorial1->save();
        $tutorial2->save();

        return redirect()->back()->with(['success' => 'Swaped Tutorials Priority']);
    }

    public function destroy(Tutorial $tutorial)
    {
        
        $status = 'success';
        $message = 'Deleted tutorial successfully.';
        
        if($tutorial->puzzles()->count() > 0 || $tutorial->questions()->count() > 0) {
            $message = 'There are puzzles and questions for the tutorial.';
            $status = 'error';
        }
        else {
            $this->tutorialRepo->deleteInstance($tutorial);
        }

        return redirect()->back()->with([$status => $message]);
    }
}
