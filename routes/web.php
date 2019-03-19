<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

/*

    =====|| ROUTING GROUPS SYNTAX ||=====

    Syntax: 
        Route::group(['prefix' => 'sections'] , function() {
            // All routes go here
        });

    =====|| PASSING PARAMETERS ON URL ||=====

    Syntax:
        Route::get('url/{parameter}', function($parameter) { <<< There is where parameter is passed
            // All routes go here
        });

    =====|| NOTES ON VIEWS POSSIBLE OVERLOADS ||=====

    Syntax:
        return view('whatever.whatever', ['post' => $post]) <<< This will hold a variable called $post on the view

    =====|| FACADES THROUGH DEPENDENCY INJECTION ||=====

    Route::post('blog.index', function(Request $request) {
	    // All code goes here
    });

    More information: https://laravel.com/docs/5.8/facades

    =====|| VALIDATORS ||=====

    They are inserted through dependency injection.

    Route::post('blog.index', function(Validator $validator) {

        $validation = $validator->make($request->all(), [
            'id' => 'required|min:5',
            'name' => 'required|min:10'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        }
        
    });

    =====|| CONTROLLERS ON ROUTES ||=====

    THIS: 

    Route::get('/', function () {
        return view('sections.welcome');
    })->name('sections.welcome');

    IS CONVERTED TO:

    Route::get('/', [
        'uses' => SectionController@getWelcomePage', <<< ControllerName@methodName
        'as' => 'sections.welcome' <<< Route name
    ]);


*/

// Route::get('/', function () {
//     return view('sections.welcome');
// })->name('sections.welcome');

Route::get('/', [
    'uses' => 'SectionController@getWelcomePage',
    'as' => 'sections.welcome'
]);

Route::group(['prefix' => 'sections'], function() {

    Route::get('one', function() {
        return view('sections.one');
    })->name('sections.one');;
    
    Route::get('two', function() {
        return view('sections.two');
    })->name('sections.two');;
    
    Route::get('three', function() {
        return view('sections.three');
    })->name('sections.three');;

});

// Avoid dots on views names due to Laravel interprets that as directory divisions.

Route::get('csrf-form', function(Request $request) {
    return view('sections.csrf-form');
})->name('csrf.form');

Route::post('csrf-response', function(Request $request, Factory $validator) {

    $validation = $validator->make($request->all(), [
        'id' => 'required|min:5',
        'name' => 'required|min:10'
    ]);

    if ($validation->fails()) {
        return redirect()->route('sections.welcome')->withErrors($validation);
    }  

    $info = [
        'id' => $request->input('id'),
        'name' => $request->input('name')
    ];

    // Here we avoid returning directly a view in order to not resend post requests to server
    // Then redirects are used

    return redirect()
            ->route('sections.welcome')
            ->with('info', $info);

})->name('csrf.response');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

