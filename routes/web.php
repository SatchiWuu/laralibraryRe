<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/authors', function () {
    return view('authors.index');
});
Route::get('/publisher', function () {
    return view('publisher.index');
});
Route::get('/book', function () {
    return view('book.index');
});
