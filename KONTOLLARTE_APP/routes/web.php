<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

Route::get('/', [
    'uses' => 'ShowController@display',
    'as' => 'shows.display.root'
]);

Route::group(['prefix' => 'shows'], function() {

    Route::get('display', [
        'uses' => 'ShowController@display',
        'as' => 'shows.display'
    ]);

    Route::get('next', [
        'uses' => 'ShowController@getNextSliderImage',
        'as' => 'shows.next',
        'middleware' => 'signed'
    ]);

    Route::get('previous', [
        'uses' => 'ShowController@getPreviousSliderImage',
        'as' => 'shows.previous',
        'middleware' => 'signed'
    ]);

    Route::get('count', [
        'uses' => 'ShowController@getNumberOfShows',
        'as' => 'shows.count',
        'middleware' => 'signed'
    ]);
    
    Route::post('get_hash_url_token', [
        'uses' => 'ShowController@getUrlHashToken'
    ]);
});

Route::group(['prefix' => 'account'], function() {

    Route::get('display', [
        'uses' => 'AccountController@display',
        'as' => 'account.display'
    ]);

    Route::post('validate', [
        'uses' => 'AccountController@validateUpdate',
        'as' => 'account.validate'
    ]);

    Route::post('delete', [
        'uses' => 'AccountController@deleteAccount',
        'as' => 'account.delete'
    ]);
    
});

Route::group(['prefix' => 'paintings'], function() {

   Route::get('display', [
        'uses' => 'PaintingsController@display',
        'as' => 'paintings.display'
    ]);

    Route::get('load/{id}/{imagesLoaded}/{remainingImages}', [
        'uses' => 'PaintingsController@loadMorePictures',
        'as' => 'paintings.load',
        'middleware' => 'signed'
    ]);
    
   Route::post('upload', [
       'uses' => 'PaintingsController@uploadPaint',
       'as' => 'paintings.upload'
    ]);

   Route::post('get_image_preview', [
        'uses' => 'PaintingsController@getImagePreview',
        'as' => 'paintings.get_preview'
    ]);

    Route::post('delete_preview', [
        'uses' => 'PaintingsController@deletePreviews',
        'as' => 'paintings.delete_preview'
    ]);

    Route::post('get_hash_url_token', [
        'uses' => 'PaintingsController@getUrlHashToken'
    ]);

    Route::post('update', [
        'uses' => 'PaintingsController@updatePaint',
        'as' => 'paintings.update'
    ]);

    Route::post('delete', [
        'uses' => 'PaintingsController@deletePaint',
        'as' => 'paintings.delete'
    ]);

});

Route::group(['prefix' => 'galleries'], function() {

    Route::get('display', [
        'uses' => 'GalleriesController@display',
        'as' => 'galleries.display'
    ]);

    Route::post('add/{galleryId}', [
        'uses' => 'GalleriesController@addGallery',
        'as' => 'galleries.add'
    ]);

    Route::get('details', [
        'uses' => 'GalleriesController@getGalleryDetails',
        'as' => 'galleries.details',
        'middleware' => 'signed'
    ]);

    Route::post('delete/{galleryId}', [
        'uses' => 'GalleriesController@deleteGallery',
        'as' => 'galleries.delete'
    ]);

    Route::get('reload', [
        'uses' => 'GalleriesController@reloadGalleries',
        'as' => 'galleries.reload',
        'middleware' => 'signed'
    ]);

    Route::post('get_hash_url_token', [
        'uses' => 'GalleriesController@getUrlHashToken'
    ]);

});

Route::group(['prefix' => 'paintings'], function() {

    Route::get('display', [
         'uses' => 'PaintingsController@display',
         'as' => 'paintings.display'
     ]);
 
    Route::get('load/{id}/{imagesLoaded}/{imagesToLoad}', [
         'uses' => 'PaintingsController@loadMorePictures',
         'as' => 'paintings.load'
     ]);
 
    Route::post('upload', [
        'uses' => 'PaintingsController@uploadPaint',
        'as' => 'paintings.upload'
     ]);
 
    Route::post('get_image_preview', [
         'uses' => 'PaintingsController@getImagePreview',
         'as' => 'paintings.get_preview'
     ]);
 
     Route::post('delete_preview', [
         'uses' => 'PaintingsController@deletePreviews',
         'as' => 'paintings.delete_preview'
     ]);
 
 });
 
 Route::group(['prefix' => 'messages'], function() {
 
     Route::get('display', [
         'uses' => 'MessagesController@display',
         'as' => 'messages.display'
     ]);

     Route::get('handle_request', [
        'uses' => 'MessagesController@handleMessageRequest',
        'as' => 'messages.request', 
        'middleware' => 'signed'
    ]);

    Route::post('execute_request', [
        'uses' => 'MessagesController@executeMessageRequest',
        'as' => 'messages.execute'
    ]);

    Route::post('get_hash_url_token', [
        'uses' => 'MessagesController@getUrlHashToken'
    ]);
 
 
 });

 Route::group(['prefix' => 'sales'], function() {

    Route::get('display', [
        'uses' => 'SalesController@display',
        'as' => 'sales.display'
    ]);

    Route::post('upload_on_ebay', [
        'uses' => 'SalesController@uploadPaintOnEbay',
        'as' => 'sales.upload'
    ]);

 });

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
