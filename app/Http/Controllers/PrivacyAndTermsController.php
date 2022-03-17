<?php

namespace App\Http\Controllers;

use App\Repositories\TechEntityRepository;

class PrivacyAndTermsController extends Controller {

    public function __construct(TechEntityRepository $techEntityRepo) 
    {
        $this->techEntityRepo = $techEntityRepo;
    }

    public function showPrivacyPolicy() {

        $techEntities = $this->techEntityRepo->getAll();
        return view('privacy-policy', compact('techEntities'));
    }

    public function showTermsAndConditions() {

        $techEntities = $this->techEntityRepo->getAll();
        return view('terms-and-conditions', compact('techEntities'));
    }
}