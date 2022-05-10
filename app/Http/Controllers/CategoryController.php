<?php

namespace App\Http\Controllers;

use App\Repositories\TechEntityRepository;
use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception, Log;

class CategoryController extends Controller {

    public function __construct(TechEntityRepository $techEntityRepo, CategoryRepository $categoryRepo) 
    {
        $this->techEntityRepo = $techEntityRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function create()
    {
        $techEntities = $this->techEntityRepo->getAll();

        return view('categories.create', compact('techEntities'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, config('validations.category'));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if($this->categoryRepo->containsColumnWithValue('pretty_name', $request->pretty_name)) {
            return redirect()->back()->withErrors(['pretty_name' => 'Category with such pretty name already exists.'])->withInput();
        }

        if($this->categoryRepo->containsColumnWithValue('url_name', $request->url_name)) {
            return redirect()->back()->withErrors(['url_name' => 'Category with such url name already exists.'])->withInput();
        }

        try {
            $this->categoryRepo->create($params);
        }
        catch(Exception $e) {
            Log::error($e);

            return redirect()->back()->withError('Failed creating category. Check log file.')->withInput();
        }

        return redirect()->back()->with(['success' => 'Created category successfully.']);
    }

    public function index()
    {
        $techEntities = $this->techEntityRepo->getAll();
        $categories = $this->categoryRepo->getAll();

        return view('categories.index', compact('techEntities', 'categories'));
    }

    public function edit(Category $category)
    {
        $techEntities = $this->techEntityRepo->getAll();

        return view('categories.edit', compact('techEntities', 'category'));
    }

    public function update(Category $category, Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, config('validations.category'));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reqPrName = $request->pretty_name;
        if($reqPrName !== $category->pretty_name && $this->categoryRepo->containsColumnWithValue('pretty_name', $reqPrName)) {
            return redirect()->back()->withErrors(['pretty_name' => 'Category with such pretty name already exists.'])->withInput();
        }

        $reqUrlName = $request->url_name;
        if($reqUrlName !== $category->url_name && $this->categoryRepo->containsColumnWithValue('url_name', $reqUrlName)) {
            return redirect()->back()->withErrors(['url_name' => 'Category with such url name already exists.'])->withInput();
        }

        try {
            $this->categoryRepo->updateInstance($category, $params);
        }
        catch(Exception $e) {
            Log::error($e);

            return redirect()->back()->withError('Failed creating category. Check log file.')->withInput();
        }

        return redirect()->back()->with(['success' => 'Edited category successfully.']);
    }

    public function destroy(Category $category)
    {
        $status = 'success';
        $message = 'Deleted category successfully.';

        if($this->categoryRepo->hasAnyTutorials($category)) {
            $status = 'error';
            $message = "To delete category first delete all of it's tutorials.";
        }
        else {
            try {
                $this->categoryRepo->deleteInstance($category);
            } 
            catch(Exception $e) {
                Log::error($e);
    
                $message = "Failed deleting category. Check log file.";
            }
        }

        return redirect()->back()->with([$status => $message]);
    }
}