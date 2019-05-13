<?php

use App\Issue;
use Illuminate\Support\Facades\DB;

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


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/', 'HomeController')->name('dashboard');
    Route::get('/get-statistics', 'HomeController@getStatistics')->name('statistics');
    Route::get('/pmodels/{model}', 'HomeController@problemsByModel')->name('pmodels');
    
    Route::get('/issue/modify','IssueController@getClientInfo')->name('modify.client');
    Route::put('/issue/modify/client/{imei}','IssueController@setClientInfo');
    
    Route::get('/issues/create','IssueController@create')->name('issues.create');
    
    Route::group(['middleware' => ['admin']], function () {
        
        Route::resource('/commercials', 'CommercialController');
        Route::resource('/users', 'UserController');
        Route::put('/users/password/{id}', 'UserController@updatePassword')->name('users.changePassword');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        Route::post('/issues/back-stage-2/{issue}','IssueController@backStage2')->name('issues.backstage2');
    });

    Route::group(['middleware' => ['sav']], function () {
        
        Route::resource('/problems', 'ProblemController');
        Route::resource('/solutions', 'SolutionController');
        Route::get('/issues','IssueController@index')->name('issues.index');
        Route::get('/issues/list','IssueController@list')->name('issues.list');
        Route::get('/issues/images','IssueController@images')->name('issues.images');
        Route::post('/issues','IssueController@store')->name('issues.store');
        Route::post('/issues/final-step/{issue}','IssueController@finalUpdate')->name('issues.finalupdate');
        Route::get('/issues/report/{issue}','IssueController@report')->name('issues.report');
        Route::get('/issues/{issue}','IssueController@show')->name('issues.details');
        Route::post('/issues/{issue}','IssueController@update')->name('issues.update');
        Route::delete('/issues/{issue}','IssueController@destroy')->name('issues.delete');

    });    
});

Auth::routes();