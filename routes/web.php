<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrixImageUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/trix-image-upload', [TrixImageUploadController::class, 'store'])->name('trix.image.upload');

Route::get('/admin/dashboard', function () {
    return redirect('/admin');
});

Route::group(['prefix' => getPrefix()], function() { 
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/list', [PageController::class,'list']);
    Route::get('/page/{slug}', [PageController::class,'show']);
});



