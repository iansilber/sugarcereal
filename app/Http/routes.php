<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showWelcome']);
Route::get('bid', ['as' => 'bid', 'uses' => 'HomeController@bid']);
Route::post('bid', 'HomeController@store');

Route::get('charge', ['as' => 'charge', 'uses' => 'HomeController@charge']);

Route::get('terms', ['as' => 'terms', function () {
    return View::make('terms');
}]);

Route::get('about', ['as' => 'about', function () {
    return View::make('about');
}]);

Route::get('test', ['as' => 'test', function () {
    return View::make('test');
}]);
