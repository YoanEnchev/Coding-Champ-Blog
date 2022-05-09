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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    
    Route::post('tutorials/{tutorial}/comment', 'CommentController@store')->name('comment.store');

    Route::group(['prefix' => 'admin/', 'as' => 'admin.', 'middleware' => ['admin']], function () {
        Route::resource('tutorial', 'TutorialController')->except('show', 'index');
        
        Route::resource('tech-entity', 'TechEntityController')->except('delete', 'show');
        
        Route::group(['prefix' => 'tutorials/', 'as' => 'tutorial.'], function () {
            Route::get('priority-listing', 'TutorialController@priorityListing')->name('priority-listing');
            Route::post('swap/{tutorial1}/{tutorial2}', 'TutorialController@swapPriorities')->name('swap-priorities');
    
            Route::get('{techEntity}', 'TutorialController@listInAdminPanel')->name('index');
            Route::get('{techEntity}/{category}', 'TutorialController@getTutorialsInTechEntityAndCat')->name('in-techEntity.category');
        });
    });
});


Route::get('/', 'HomeController@show')->name('home');

Route::get('tutorials/{techEntityUrl}', 'TutorialController@index')->name('tutorials.index');
Route::get('tutorials/{techEntityUrl}/{tutorialUrl}', 'TutorialController@show')->name('tutorials.show');
Route::get('tags/{techEntityUrl}/{tagUrlName}', 'TagController@show')->name('tags.show');