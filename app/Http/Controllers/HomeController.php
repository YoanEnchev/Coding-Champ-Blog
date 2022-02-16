<?php

namespace App\Http\Controllers;

class HomeController extends Controller {

    public function show() {

        $title = 'Coding Champ - Learn Programming via challenges.';
        $description = "Learn programming via challenges! Coding Champ makes programming fun and interactive for the languages - Python, Java, JavaScript, C++, C# and PHP! Programming has never been easier!";
        $keywords = 'Programming, Coding, Fun, Interactive, Mobile App, Programming Languages';

        return view('welcome', compact('title', 'description', 'keywords'));
    }
}