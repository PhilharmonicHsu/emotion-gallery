<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnalysisResultController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload', [AnalysisResultController::class, 'upload'])->name('upload');
Route::get('/analysis/{analysisResult:id}', [AnalysisResultController::class, 'getAnalysisResult']);
Route::get('/recent-analysis', [AnalysisResultController::class, 'getRecentAnalysisResults']);
