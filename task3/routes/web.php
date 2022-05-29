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

Route::post('/create_article', UserController::class.'@createArticle')->name('article-create')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/get_user_articles', UserController::class.'@getUserArticles')->name('get-user-articles')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/get_article_author', ArticleController::class.'@getArticleAuthor')->name('get-article-author')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/change_article_author', ArticleController::class.'@changeArticleAuthor')->name('change-article-author')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
