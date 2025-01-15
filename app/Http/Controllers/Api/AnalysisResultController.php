<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\AnalysisResultService;
use App\Http\Services\ImageAnalysisService;
use App\Models\AnalysisResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Storage;

class AnalysisResultController extends Controller
{
    private ImageAnalysisService $imageAnalysisService;
    private AnalysisResultService $analysisResultService;

    public function __construct(
        ImageAnalysisService $imageAnalysisService,
        AnalysisResultService $analysisResultService
    ) {
        $this->imageAnalysisService = $imageAnalysisService;
        $this->analysisResultService = $analysisResultService;
    }
    public function upload(Request $request): RedirectResponse
    {
        // 驗證上傳的圖片
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('images', 's3');
        $url = Storage::disk('s3')->url($path);

        $analysisResult = $this->imageAnalysisService->analyze($request);
        $analysisResult['image'] = $url;

        $createdAnalysisResult = $this->analysisResultService->createAnalysisResult($analysisResult);

        return redirect()->route('analysis-results', ['id' => $createdAnalysisResult->id]);
    }

    public function getAnalysisResult(AnalysisResult $analysisResult): JsonResponse
    {
        return response()->json($analysisResult);
    }

    public function getRecentAnalysisResults(): JsonResponse
    {
        $list = $this->analysisResultService->getRecentAnalysisResults();

        return response()->json($list);
    }
}
