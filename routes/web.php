<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/articles', 'articles.index')->name('articles.index');
Route::view('/articles/{slug}', 'articles.show')->name('articles.show');
Route::view('/resources', 'resources.index')->name('resources.index');
Route::view('/about', 'about.index')->name('about.index');
Route::view('/contact', 'contact.index')->name('contact.index');
Route::view('/privacy-policy', 'legal.privacy')->name('legal.privacy');
Route::view('/terms-and-conditions', 'legal.terms')->name('legal.terms');
