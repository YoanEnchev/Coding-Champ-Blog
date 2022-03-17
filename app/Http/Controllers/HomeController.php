<?php

namespace App\Http\Controllers;

use App\Repositories\TechEntityRepository;

class HomeController extends Controller {

    public function __construct(TechEntityRepository $techEntityRepo) 
    {
        $this->techEntityRepo = $techEntityRepo;
    }

    public function show(TechEntityRepository $techEntityRepo)
    {
        $title = 'Coding Champ - Learn Programming via challenges.';
        $description = "Learn programming via challenges! Coding Champ makes programming fun and interactive for the languages - Python, Java, JavaScript, C++, C# and PHP! Programming has never been easier!";
        $keywords = 'Programming, Coding, Fun, Interactive, Mobile App, Programming Languages';

        $techEntities = $this->techEntityRepo->getAll();

        return view('welcome', compact('title', 'description', 'keywords', 'techEntities'));
    }
}