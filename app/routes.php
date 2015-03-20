<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('galleries');
});
Route::resource('galleries', 'GalleriesController');
Route::resource('comments', 'CommentsController');
Route::resource('articles', 'ArticlesController');
Route::resource('exels', 'exelsController');
Route::post('uploadxls','exelsController@uploadxls');
//Route::post('exportxls','exelsController@exportxls');
Route::get('/exportxls/{id}', array('as' => 'exportxls', 'uses' => 'exelsController@exportxls'));
Route::resource('users', 'UsersController', array('except' => array('index', 'destroy')));
Route::resource('sessions', 'SessionsController@create');
Route::get('logout', array('as' => 'logout', 'uses' => 'SessionsController@destroy'));
Route::resource('sessions', 'SessionsController', array('only' => array('create', 'store', 'destroy')));
Route::get('/reset-password', array('as' => 'reset-password', 'uses' => 'UsersController@reset_password'));
Route::post('/process-reset-password', array('as' => 'process-reset-password', 'uses' => 'UsersController@process_reset_password'));
Route::get('/change-password/{forgot_token}', array('as' => 'change-password', 'uses' => 'UsersController@change_password'));
Route::post('/process-change-password/{forgot_token}', array('as' => 'process-change-password', 'uses' => 'UsersController@process_change_password'));

