<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\TextAnalysisController;
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
    return view('test-index');
});

Route::get('/upload', function () {
    return view('upload-image');
});

Route::get('/analysis-results', function () {
   return view('analysis-results');
})->name('analysis-results');

Route::get('/image-analysis', function () {
    return view('upload');
});

Route::get('/text-analysis', function () {
    return view('text-analysis');
});

Route::get('/test-page', function () {
   return view('test-page');
});

Route::post('/image/analyze', [ImageController::class, 'analyze'])->name('image.analyze');
Route::post('/text/analyze', [TextAnalysisController::class, 'analyze'])->name('text.analyze');
