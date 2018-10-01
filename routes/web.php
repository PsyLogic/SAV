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

Route::get('/test',function(){
    phpinfo();
});


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');
    
    Route::get('/issues/create','IssueController@create')->name('issues.create');
    
    Route::group(['middleware' => ['admin']], function () {
        
        Route::resource('/commercials', 'CommercialController');
        Route::resource('/users', 'UserController');
        Route::put('/users/password/{id}', 'UserController@updatePassword')->name('users.changePassword');
        
    });

    Route::group(['middleware' => ['sav']], function () {
        
        Route::resource('/problems', 'ProblemController');
        Route::resource('/solutions', 'SolutionController');
        Route::get('/issues','IssueController@index')->name('issues.index');
        Route::get('/issues/images','IssueController@images')->name('issues.images');
        Route::post('/issues','IssueController@store')->name('issues.store');
        Route::post('/issues/final-step/{id}','IssueController@finalUpdate')->name('issues.finalupdate');
        Route::get('/issues/report/{id}','IssueController@report')->name('issues.report');
        Route::get('/issues/{id}','IssueController@show')->name('issues.details');
        Route::post('/issues/{id}','IssueController@update')->name('issues.update');
        Route::delete('/issues/{id}','IssueController@delete')->name('issues.delete');

    });    
});

Auth::routes();