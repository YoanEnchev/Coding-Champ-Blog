<?php

namespace App\Http\Controllers;

use App\Repositories\TechEntityRepository;
use App\Models\TechEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception, Log;

class TechEntityController extends Controller {

    public function __construct(TechEntityRepository $techEntityRepo) 
    {
        $this->techEntityRepo = $techEntityRepo;
    }

    public function create()
    {
        $techEntities = $this->techEntityRepo->getAll();

        return view('tech-entities.create', compact('techEntities'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, config('validations.tech_entity'));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if($this->techEntityRepo->containsColumnWithValue('pretty_name', $request->pretty_name)) {
            return redirect()->back()->withErrors(['pretty_name' => 'Tech Entity with such pretty name already exists.'])->withInput();
        }

        if($this->techEntityRepo->containsColumnWithValue('url_name', $request->url_name)) {
            return redirect()->back()->withErrors(['url_name' => 'Tech Entity with such url name already exists.'])->withInput();
        }

        try {
            $this->techEntityRepo->create($params);
        }
        catch(Exception $e) {
            Log::error($e);

            return redirect()->back()->withError('Failed creating tech entity. Check log file.')->withInput();
        }

        return redirect()->back()->with(['success' => 'Created tech entity successfully.']);
    }

    public function index()
    {
        $techEntities = $this->techEntityRepo->getAll();

        return view('tech-entities.index', compact('techEntities'));
    }

    public function edit(TechEntity $techEntity)
    {
        $techEntities = $this->techEntityRepo->getAll();

        return view('tech-entities.edit', compact('techEntities', 'techEntity'));
    }

    public function update(TechEntity $techEntity ,Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, config('validations.tech_entity'));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reqPrName = $request->pretty_name;
        if($reqPrName !== $techEntity->pretty_name && $this->techEntityRepo->containsColumnWithValue('pretty_name', $reqPrName)) {
            return redirect()->back()->withErrors(['pretty_name' => 'Tech Entity with such pretty name already exists.'])->withInput();
        }

        $reqUrlName = $request->url_name;
        if($reqUrlName !== $techEntity->url_name && $this->techEntityRepo->containsColumnWithValue('url_name', $request->url_name)) {
            return redirect()->back()->withErrors(['url_name' => 'Tech Entity with such url name already exists.'])->withInput();
        }

        try {
            $this->techEntityRepo->updateInstance($techEntity, $params);
        }
        catch(Exception $e) {
            Log::error($e);

            return redirect()->back()->withError('Failed editing tech entity. Check log file.')->withInput();
        }

        return redirect()->back()->with(['success' => 'Edited tech entity successfully.']);
    }

    public function destroy(TechEntity $techEntity)
    {
        $status = 'success';
        $message = 'Deleted tech entity successfully.';

        if($this->techEntityRepo->getTutorials($techEntity)->count() > 0) {
            $status = 'error';
            $message = "To delete tech entity first delete all of it's tutorials.";
        }
        else {
            try {
                $this->techEntityRepo->deleteInstance($techEntity);
            } 
            catch(Exception $e) {
                Log::error($e);
    
                $message = "Failed deleting tech entity. Check log file.";
            }
        }

        return redirect()->back()->with([$status => $message]);
    }
}