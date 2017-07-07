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
Route::group(array('prefix' => 'api'), function() {
    Route::get('student','StudentsController@index');//for view student
    Route::post('student/register','StudentsController@register');//for register
    Route::put('student/{id}/update','StudentsController@update');
    Route::delete('student/{id}/destroy','StudentsController@destroy');
    Route::get('student/search','StudentsController@search');
    Route::post('student/login','StudentsController@login');
    Route::get('student/{id}','StudentsController@show');
});
