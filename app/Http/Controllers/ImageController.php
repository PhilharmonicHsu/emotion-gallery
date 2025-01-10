<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    private ImageAnalysisService $imageAnalysisService;

    public function __construct(ImageAnalysisService $imageAnalysisService) {
        $this->imageAnalysisService = $imageAnalysisService;
    }
    public function analyze(Request $request): JsonResponse
    {
        // 驗證上傳的圖片
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return $this->imageAnalysisService->analyze($request);
    }
}
