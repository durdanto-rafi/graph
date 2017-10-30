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

Route::get('/', ['as'=>'/','uses'=>'GraphController@index']);
Route::resource('graph', 'GraphController');
Route::post('graphData', ['as'=>'graphData','uses'=>'GraphController@getGraphData']);
Route::post('subjectContents', ['as'=>'subjectContents','uses'=>'GraphController@getSubjectContents']);

Route::resource('login','LoginController');
Route::get('logout', ['as'=>'logout','uses'=>'LoginController@logout']);
Route::post('transcribe', ['as'=>'transcribe','uses'=>'GraphController@getTranscribe']);
Route::post('convert', ['as'=>'convert','uses'=>'GraphController@convertToAudio']);
Route::post('speech-to-text', ['as'=>'speech-to-text','uses'=>'GraphController@speechToText']);
Route::get('progress', ['as'=>'progress','uses'=>'GraphController@getProgess']);
Route::post('image-to-text', ['as'=>'image-to-text','uses'=>'GraphController@convertImageToText']);
Route::post('ocr', ['as'=>'ocr','uses'=>'GraphController@detectTextFromImage']);