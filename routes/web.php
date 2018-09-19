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
Route::put('/users/password/{id}', 'UserController@updatePassword')->name('users.changePassword');
Route::resource('/problems', 'ProblemController');
Route::resource('/solutions', 'SolutionController');

Route::get('/issues','IssueController@index')->name('issues');
Route::get('/issues/images','IssueController@images')->name('issues.images');
Route::get('/issues/create','IssueController@create')->name('issues.create');
Route::post('/issues','IssueController@store')->name('issues.store');
Route::post('/issues/final-step/{id}','IssueController@finalUpdate')->name('issues.finalupdate');
Route::get('/issues/{id}','IssueController@show')->name('issues.details');
Route::post('/issues/{id}','IssueController@update')->name('issues.update');
Route::delete('/issues/{id}','IssueController@delete')->name('issues.delete');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/invoice',function(){
    return view('issue.invoice');
});