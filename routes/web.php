<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrixImageUploadController;

Route::post('/trix-image-upload', [TrixImageUploadController::class, 'store'])->name('trix.image.upload');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return redirect('/admin');
});
