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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('/commercials', 'CommercialController');
Route::resource('/users', 'UserController');
Route::put('/users/password/{id}', 'UserController@updatePassword');
Route::resource('/problems', 'ProblemController');

Route::get('/issues','IssueController@index');
Route::get('/issues/images','IssueController@images');
Route::get('/issues/create','IssueController@create');
Route::post('/issues','IssueController@store');
Route::post('/issues/final-step/{id}','IssueController@finalUpdate');
Route::get('/issues/{id}','IssueController@show');
Route::post('/issues/{id}','IssueController@update');
Route::delete('/issues/{id}','IssueController@delete');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
