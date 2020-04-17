<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions','QuestionController')->except('show');

Route::get('questions/{slug}','QuestionController@show')->name('questions.show');

Route::resource('questions.answers','AnswerController')->except(['index','create','show']);
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

Route::post('/questions/{question}/favourites', 'FavouritesController@store')->name('questions.favourite');
Route::delete('/questions/{question}/favourites', 'FavouritesController@destroy')->name('questions.unfauvorite');

Route::post('/questions/{question}/vote', 'VoteQuestionController');
Route::post('/answers/{answer}/vote', 'VoteAnswerController');
