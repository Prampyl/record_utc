<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecordController::class, 'index'])->name('home');
Route::resource('records', RecordController::class);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
