<?php

use App\Http\Controllers\RssFeedController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Legacy Redirects
|--------------------------------------------------------------------------
|
| Redirect old indexed URLs from the previous website to the new homepage.
| These are known legacy URLs from Google Search Console.
|
*/

Route::get('/', function (Request $request) {
    if ($request->has('s')) {
        return redirect('/', 301);
    }

    return view('articles.index');
})->name('home');

foreach (config('legacy-redirects.paths', []) as $oldPath => $newPath) {
    Route::redirect($oldPath, $newPath, 301);
}

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/rss.xml', RssFeedController::class)->name('rss.feed');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::view('/articles/category/{category}', 'articles.index')->name('articles.category');
Route::view('/articles/{slug}', 'articles.show')->name('articles.show');

Route::view('/search', 'search.index')->name('search.index');
Route::view('/resources', 'resources.index')->name('resources.index');
Route::view('/about', 'about.index')->name('about.index');
Route::view('/contact', 'contact.index')->name('contact.index');

Route::view('/privacy-policy', 'legal.privacy')->name('legal.privacy');
Route::view('/terms-and-conditions', 'legal.terms')->name('legal.terms');
