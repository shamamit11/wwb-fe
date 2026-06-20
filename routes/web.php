<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/articles', 'articles.index')->name('articles.index');
Route::view('/articles/{slug}', 'articles.show')->name('articles.show');
Route::view('/resources', 'resources.index')->name('resources.index');
