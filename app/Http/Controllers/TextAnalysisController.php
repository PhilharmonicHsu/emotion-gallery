<?php

namespace App\Http\Controllers;

use App\Http\Services\TextAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TextAnalysisController extends Controller
{
    private TextAnalysisService $textAnalysisService;

    public function __construct(TextAnalysisService $textAnalysisService) {
        $this->textAnalysisService = $textAnalysisService;
    }

    public function analyze(Request $request): JsonResponse
    {
        // 驗證輸入文本
        $request->validate([
            'text' => 'required|string|max:1000',
        ]);

        $text = $request->input('text');

        return $this->textAnalysisService->analyze($text);
    }
}
