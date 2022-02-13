<?php

namespace App\Http\Controllers;

class PrivacyAndTermsController extends Controller {

    public function showPrivacyPolicy() {
        return view('privacy-policy');
    }

    public function showTermsAndConditions() {
        return view('terms-and-conditions');
    }
}