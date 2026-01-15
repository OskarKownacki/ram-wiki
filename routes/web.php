<?php

use App\Livewire\Edit\EditMain;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/edit', EditMain::class)->name('edit.main')->middleware(['auth', 'admin']);
Route::get('/login', HomePage::class)->name('login');
Route::get('/register', HomePage::class)->name('register');
