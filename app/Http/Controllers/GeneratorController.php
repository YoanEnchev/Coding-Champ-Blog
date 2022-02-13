<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Propaganistas\LaravelFakeId\Facades\FakeId;
use App\Category;
use App\TechEntity;
use App\Tutorial;
use App\Project;
use App\Challenge;
use App\User;
use App\Helpers\Converter;

class GeneratorController extends Controller
{
    public function mobileAppDataFile(Request $request)
    {
        $techAssets = TechEntity::orderBy('priority')->get();
        $categories = Category::all();
        $tutorials = Tutorial::with(['questions', 'puzzles'])
            ->orderBy('priority')
            ->get();

        $projects = Project::orderBy('priority')->get();
        $challenges = Challenge::orderBy('priority')->get();

        $data = [];

        foreach($techAssets as $techEntity) {

            $categoriessData = [];
            foreach($categories as $category) {
                $categoriessData[$category->pretty_name] = [];

                $subTutorials = $tutorials
                    ->where('tech_entity_id', '=', $techEntity->id)
                    ->where('category_id', '=', $category->id)
                    ->all();   
                    
                $tutorialsData = [];    

                foreach($subTutorials as $tutorial) {

                    $tutorialQuestions = [];

                    foreach($tutorial->questions as $question) {
                        $tutorialQuestions[] = [
                            'id' => $question->fake_id,
                            'question' => $question->text ?? "What's the output of the code snippet?",
                            'code'=>  $question->code,
                            'answers' => $question->all_answers,
                            'correct_answer' => $question->correct_answer,
                            'explanation' => $request->use_explanation ? $question->explanation : ''
                        ];
                    }

                    $tutorialPuzzles = [];
                    
                    foreach($tutorial->puzzles as $puzzle) {
                        $tutorialPuzzles[] = [
                            'id' => $puzzle->fake_id,
                            'text' => $puzzle->text ?? 'Fill the missing words to match the output.',
                            'code' => $puzzle->code,
                            'result' => $puzzle->output,
                            'words' => [
                                'operators' => $puzzle->operators,
                                'values' => $puzzle->values,
                                'variables_constants' => $puzzle->variables_constants,
                                'others' => $puzzle->others
                            ],
                            'correct_patterns' => $puzzle->correct_patterns,
                        ];
                    }

                    
                    $tutorialsData[] = [
                        'id' => $tutorial->fake_id,
                        'name' => $tutorial->pretty_name,
                        'tests' => $tutorialQuestions,
                        'puzzles' => $tutorialPuzzles
                    ];
                }
                
                $categoriessData[$category->pretty_name] = $tutorialsData;
            }

            $projectsData = [];

            $projectsForTechEntity = $projects->where('tech_entity_id', '=', $techEntity->id);

            foreach($projectsForTechEntity as $project) {

                $currentProjectData = [
                    'id' => $project->fake_id,
                    'name' => $project->name,
                    'description' => $project->description,
                    'inputs' => json_decode($project->inputs),
                    'outputs' => json_decode($project->outputs),
                    'solution' => $project->solution,
                    'stars' => $project->stars,
                    'requirements' => $project->requirements()->pluck('name')
                ];


                if(isset($project->image_extension)) {
                    $currentProjectData['image'] = $project->name . '.' . $project->image_extension; 
                }

                $projectsData[] = $currentProjectData;
            }

            $challengesData = [];
            $challengesForTechEntity = $challenges->where('tech_entity_id', '=', $techEntity->id);
            
            foreach($challengesForTechEntity as $challenge) {
                $challengesData[] = [
                    'id' => $challenge->fake_id,
                    'name' => $challenge->name,
                    'description_html' => $challenge->description_html,
                    'stars' => $challenge->stars,
                    'chapters' => $challenge->chapters,
                    'is_premium' => $challenge->is_premium,
                    'solution_code' => $challenge->solution_code,
                    'topics' => $challenge->topics()->pluck('name')
                ];
            }
            
            
            $data[$techEntity->pretty_name] = [
                'urlName' => $techEntity->url_name,
                'mode' => $techEntity->cm_mode,
                'tutorials' => $categoriessData,
                'projects' => $projectsData,
                'challenges' => $challengesData
            ];
        }

        File::put( storage_path() .'/data.js', json_encode($data));

        echo 'Updated storage/data.js file.';
    }

    public function updateSitemap() {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n" .
        '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\r\n";


        $urls = [ route('home'), route('techEntities.index') ];

        $techEntities = TechEntity::with('tutorials')
            ->orderBy('priority')->get();

        foreach($techEntities as $techEntity) {
            $urls[] = route('tutorials.index', ['techEntityUrl' => $techEntity->url_name]);
        
            foreach($techEntity->tutorials as $tutorial) { 
                $urls[] = route('tutorials.show', ['techEntityUrl' => $techEntity->url_name, 'tutorialUrl' => $tutorial->url_name]);
            }
        }

        foreach($urls as $url) {
            $content .= "      <url><loc>$url</loc></url>\r\n";
        }

        $content .= '</urlset>';

        File::put( public_path() .'/sitemap.xml', $content);

        echo 'Updated public/sitemap.xml file.';
    }

    public function printUserIds() {

        return FakeId::encode(1);

        $users = User::all()->sort(function($u1, $u2) {
            
            $a = strval($u1->fake_id);
            $b = strval($u2->fake_id);
            
            if ($a == $b) {
                return 0;
            }
        
            return strcmp($a, $b);
        });

        return view('user-battles.index', compact('users'));
    }
}