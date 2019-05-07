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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show');
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');

// Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
// AnswersController@index, create, showは、QuestionsController@showで共に表示されるので不要
Route::resource('/questions.answers', 'AnswersController')->except(['index', 'create', 'show']);

// ベストアンサー
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

// お気に入り
Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

// question用vote機能
Route::post('/questions/{question}/vote', 'VoteQuestionController');

// answer用vote機能
Route::post('/answers/{answer}/vote', 'VoteAnswerController');
