<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', function () {
    return view('welcome');
})->name('login');

Route::get('/register', function () {
    return view('welcome');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/logout', function () {
    return redirect('/');
})->name('logout');
