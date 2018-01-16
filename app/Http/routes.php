<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('layouts.app');
});
//Route::post('upload', function (){
//    return "hello";
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::post('Transaction/Retail/getResource', 'RetailController@getResource');
    Route::post('Transaction/{id}/Retail/getTransactionResources', 'RetailController@getTransactionResources');

    Route::post('Transaction/{id}/Retail/getResource', 'RetailController@getResource');

    //routes for export for each resource
    Route::post('Card/export', 'CardsController@exportToExcel');
    Route::post('Poster/export', 'PostersController@exportToExcel');
    Route::post('Picture/export', 'PicturesController@exportToExcel');
    Route::post('Mug/export', 'MugsController@exportToExcel');
    Route::post('Book/export', 'BooksController@exportToExcel');

    Route::get('/', 'HomeController@index');
    Route::resource('Book', 'BooksController');
    Route::resource('Writer', 'WritersController');
    Route::resource('Poster', 'PostersController');
    Route::resource('Picture', 'PicturesController');
    Route::resource('Artist', 'ArtistsController');
    Route::resource('Card', 'CardsController');
    Route::resource('Mug', 'MugsController');
    Route::resource('Client', 'ClientsController');
    Route::resource('Transaction', 'TransactionsController');

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
