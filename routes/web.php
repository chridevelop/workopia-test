<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\JobController;

// Αυτό το route θα στέλνει την αρχική σελίδα στον Controller
Route::get('/', [JobController::class, 'index']);

// Αυτό το route θα στέλνει το /jobs στον Controller
Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
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
