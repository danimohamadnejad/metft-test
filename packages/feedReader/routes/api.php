<?php
use Illuminate\Support\Facades\Route;
use Metft\FeedReader\Http\Controllers\NewsServerController;
use Metft\FeedReader\Http\Controllers\NewsController;
Route::apiresource("news-servers", NewsServerController::class)->except(['create', 'edit']);
Route::apiresource("news", NewsController::class)->except(['create', 'edit']);  