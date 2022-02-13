<?php

namespace App\Http\Controllers;

use App\TechEntity;
use App\Tutorial;
use App\Category;
use App\Helpers\Converter;
use Illuminate\Http\Request;
use \DB;
use Illuminate\Support\Facades\File;

class TutorialController extends Controller {
    public function listInAdminPanel(TechEntity $techEntity) {
        
        $techEntityId = $techEntity->id;
        $categories = Category::with(['tutorials' => function($t) use ($techEntityId) {
            $t->where('tech_entity_id', '=', $techEntityId)
                ->with(['questions', 'puzzles'])
                ->orderBy('priority');
        }])
        ->get();

        $techEntities = TechEntity::all();

        $selectedTechEntity = $techEntity;

        return view('tutorial.listing', compact('categories',
        'techEntities', 'selectedTechEntity'));
    }

    public function index($techEntityUrl) {

        $tutorials = Tutorial::select('tutorials.pretty_name as pretty_name', 'tutorials.url_name as url_name', 'categories.pretty_name as category_pretty_name',
            'categories.url_name as category_url_name', 'tech_entities.url_name as tech_entity_url_name', 'tech_entities.pretty_name as tech_entity_pretty_name')
            ->join('tech_entities', 'tutorials.tech_entity_id', '=', 'tech_entities.id')
            ->join('categories', 'categories.id', '=', 'tutorials.category_id')
            ->where('tech_entities.url_name', $techEntityUrl)
            ->orderBy('tutorials.priority')
            ->get();

        $categories = [
            'Basics' => [],
            'Advanced' => [],
            'OOP' => []
        ];

        foreach ($tutorials as $tutorial) {
            $categories[$tutorial->category_pretty_name][] = $tutorial;
        }

        $noScroll = true;
        $language = $tutorials[0]->tech_entity_pretty_name;
        $title = $language . ' Tutorials';

        $description = 'Simplified tutorials for ' . $language . '. Learn if statements, loops, arrays, data structures, functions, classes, object oriented programming (OOP) and much more.';
        $tracking = true;

        return view('tutorial.index', compact('categories', 'noScroll', 'title', 'description', 'tracking'));
    }

    public function show($techEntityUrl, $tutorialUrl) {

        if(!(is_string($techEntityUrl) || is_string($tutorialUrl))) {
            return abort(403);
        }

        $tutorials = Tutorial::select('tutorials.url_name as url_name', 'tutorials.pretty_name as pretty_name','tech_entities.cm_mode as cm_mode',
        'tech_entities.url_name as techEntityUrlName', 'tech_entities.pretty_name as techEntitPrettyName', 'tutorials.keywords as keywords', 'tutorials.description as description')
            ->join('tech_entities', 'tutorials.tech_entity_id', '=', 'tech_entities.id')
            ->join('categories', 'tutorials.category_id', '=', 'categories.id')
            ->where('tech_entities.url_name', '=', $techEntityUrl)
            ->orderBy('categories.id')
            ->orderBy('tutorials.priority')
            ->get();

        if($tutorials->isEmpty()) {
            return abort(403);
        }

        $tutorialName = ucwords(str_replace("_", " ", $tutorialUrl));
        $tutorialName = ucwords(trim(str_replace("-", " ", $tutorialName)));

        $pathtoFile = storage_path('tutorials/' . $techEntityUrl . '/' . $tutorialUrl . '.html');

        if(File::exists($pathtoFile)) {
            $content = File::get($pathtoFile);
            $actualTut = $tutorials->where('url_name', $tutorialUrl)->first();

            $cmMode = $actualTut->cm_mode;
            $title = $actualTut->techEntitPrettyName . ' - ' . $tutorialName;
            $description = $actualTut->description;
            $keywords = $actualTut->keywords;
            $tracking = true;

            return view('tutorial.show', compact('techEntityUrl' ,'tutorialName', 'title', 'tutorials', 'description', 'keywords', 'content', 'cmMode', 'tracking'));
        }

        return abort(403);
    }

    // Accessed via ajax
    public function getTutorialsInTechEntityAndCat(TechEntity $techEntity, Category $category) {
        
        $tutorials = Tutorial::where([
            ['tech_entity_id', '=', $techEntity->id],
            ['category_id', '=', $category->id]
        ])
        ->orderBy('priority')
        ->get();

        return response()->json($tutorials, 200);
    }

    public function priorityListing() {
        $techEntities = TechEntity::all();
        $categories = Category::all();

        return view('tutorial.priority-listing', compact('techEntities', 'categories'));
    }

    public function create() {
        $techEntities = TechEntity::all();
        $categories = Category::all();

        return view('tutorial.create', compact('techEntities', 'categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'tech_entity_id' => 'required | numeric',
            'category_id' => 'required | numeric',
            'name' => 'required | string'
        ]);

        $message = 'Added tutorial successfully.';
        $status = 'success';

        try {
            DB::transaction(function ($data) use($request) {
                $name = $request->name;
                $urlFriendly = Converter::makeWordUrlFriendly($name);

                $techEntityId = $request->tech_entity_id;
                $categoryId = $request->category_id;

                // So tutorial is listed as last.
                $priority = Tutorial::where([
                    ['tech_entity_id', '=', $techEntityId],
                    ['category_id', '=', $categoryId]
                ])->max('priority') + 1;

                $tutorial = new Tutorial();
                $tutorial->tech_entity_id = $techEntityId;
                $tutorial->category_id = $categoryId;
                $tutorial->url_name = $urlFriendly;
                $tutorial->pretty_name = $name;
                $tutorial->priority = $priority;
                $tutorial->keywords = "";
                $tutorial->save();
            });
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = 'error';
        }
        
        return redirect()->back()->with([$status => $message]);
    }

    public function edit(Tutorial $tutorial) {
        $puzzles = $tutorial->puzzles;
        $questions = $tutorial->questions;
        $category = $tutorial->category->pretty_name;
        
        $puzzlesCount = $puzzles->count();
        $questionsCount = $questions->count();

        $techEntity = $tutorial->techEntity;
        $puzzlesWordsCategories = [
            'operators' => 'Operators',
            'values' => 'Values',
            'variables_constants' => 'Variables / Constants',
            'others' => 'Others'
        ];

        $cmMode = $techEntity->cm_mode;

        return view('tutorial.edit',  compact('tutorial', 'puzzles',
        'questions', 'puzzlesCount', 'questionsCount', 'techEntity', 
        'puzzlesWordsCategories', 'category', 'cmMode'));
    }

    public function update(Tutorial $tutorial, Request $request) {
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
                $tutorial->url_name = $urlName;
                $tutorial->pretty_name = $request->pretty_name;
                
                if($keywords && is_string($keywords)) $tutorial->keywords = $keywords;
                if($description && is_string($description)) $tutorial->description = $description;

                $tutorial->save();
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

    public function swapPriorities(Tutorial $tutorial1, Tutorial $tutorial2) {
        $p1 = $tutorial1->priority;
        $p2 = $tutorial2->priority;

        $tutorial1->priority = $p2;
        $tutorial2->priority = $p1;

        $tutorial1->save();
        $tutorial2->save();

        return redirect()->back()->with(['success' => 'Swaped Tutorials Priority']);
    }

    public function destroy(Tutorial $tutorial) {
        $status = 'success';
        $message = 'Deleted tutorial successfully.';
        
        if($tutorial->puzzles()->count() > 0 || $tutorial->questions()->count() > 0) {
            $message = 'There are puzzles and questions for the tutorial.';
            $status = 'error';
        }
        else {
            $tutorial->delete();
        }

        return redirect()->back()->with([$status => $message]);
    }
}
