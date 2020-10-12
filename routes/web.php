<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WebController@home')->name('home');

Route::group(['middleware' => 'auth'], function () {    
    Route::get('/chat/{id}', 'VideoChatController@chatVideoCall')->name('chat.video.call');
    Route::post('/chat/message/{id}', 'VideoChatController@send')->name('chat.send');    
    Route::post('/trigger/{id}', 'VideoChatController@startVideoCall')->name('call.start');    
    Route::post('/call/hang/{id}', 'VideoChatController@hangVideoCall')->name('call.hang');
    Route::get('/videochat/{id}', 'VideoChatController@getConversacion')->name('call.get');    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
