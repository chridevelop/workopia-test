<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookmarksController;
use Illuminate\Support\Facades\Route;

// Αυτό το route θα στέλνει την αρχική σελίδα στον Controller
// 1. Αρχική
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Λίστα (Index)
Route::resource('/jobs', JobController::class)->middleware('auth')->only(['edit','create','destroy','update']);
Route::resource('/jobs', JobController::class)->except(['edit','create','destroy','update']);
Route:: middleware('guest')->group(function(){
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard')->middleware('auth');
Route::put('/profile', [ProfileController::class,'update'])->name('profile.update')->middleware('auth');

Route:: middleware('auth')->group(function() {
    Route::get('/bookmarks', [BookmarksController::class,'index'])->name('bookmarks.index');
    Route::POST('/bookmarks/{job}', [BookmarksController::class,'store'])->name('bookmarks.store');
    Route::DELETE('/bookmarks/{job}', [BookmarksController::class,'destroy'])->name('bookmarks.destroy');

});




/*Route::get('/test', function (Request $request){
    return[
        'method' => $request->method(),
        'url' => $request->url(),
        'path' => $request->path(),
        'fullurl' => $request->fullurl(),
        'ip' => $request->ip(),
        'userAgent' => $request->userAgent(),
        'header' => $request->header(),
    ];
});*/
