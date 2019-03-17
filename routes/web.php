<?php

/*

    =====|| ROUTING GROUPS SYNTAX ||=====

    Syntax: 
        Route::group(['prefix' => 'sections'] , function() {
            // All routes go here
        });
        

*/

Route::get('/', function () {
    return view('sections.welcome');
})->name('sections.welcome');

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





