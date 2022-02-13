<?php

namespace App\Http\Controllers;

use App\TechEntity;

class TechEntityController extends Controller
{
    public function index()
    {
        $techEntities = config('techEntities_link_url_pretty_name');

        return view('tech-entities.index', compact('techEntities'));
    }
}