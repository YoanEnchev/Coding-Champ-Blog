<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\TechEntity;

Auth::routes(['register' => false]);


Route::group(['prefix' => 'admin/', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('tutorial', 'TutorialController')->except('show', 'index');

    Route::group(['prefix' => 'generator/', 'as' => 'generate.'], function () {
        Route::get('update-sitemap', 'GeneratorController@updateSitemap')->name('sitemap');
    });    
	
    Route::group(['prefix' => 'tutorials/', 'as' => 'tutorial.'], function () {
        Route::get('priority-listing', 'TutorialController@priorityListing')->name('priority-listing');
        Route::post('swap/{tutorial1}/{tutorial2}', 'TutorialController@swapPriorities')->name('swap-priorities');

        Route::get('{techEntity}', 'TutorialController@listInAdminPanel')->name('index');
        Route::get('{techEntity}/{category}', 'TutorialController@getTutorialsInTechEntityAndCat')->name('in-techEntity.category');
    });
});


Route::get('/', 'HomeController@show')->name('home');

Route::get('tutorials/{techEntityUrl}', 'TutorialController@index')->name('tutorials.index');
Route::get('tutorials/{techEntityUrl}/{tutorialUrl}', 'TutorialController@show')->name('tutorials.show');