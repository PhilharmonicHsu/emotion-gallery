<?php

namespace App\Http\Services;

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageAnalysisService
{
    private TextAnalysisService $textAnalysisService;

    public function __construct(TextAnalysisService $textAnalysisService) {
        $this->textAnalysisService = $textAnalysisService;
    }

    public function analyze(Request $request): JsonResponse
    {
        // 取得圖片檔案路徑
        $imagePath = $request->file('image')->getRealPath();

        // 初始化 ImageAnnotatorClient
        $imageAnnotator = new ImageAnnotatorClient();

        $descriptions = [];
        $textAnalysis = [];

        try {
            // 構建請求
            $image = (new Image())->setContent(file_get_contents($imagePath));
            $feature = (new Feature())->setType(Feature\Type::LABEL_DETECTION);
            $annotateImageRequest = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$feature]);

            $batchRequest = (new BatchAnnotateImagesRequest())
                ->setRequests([$annotateImageRequest]);

            // 發送請求並獲取結果
            $response = $imageAnnotator->batchAnnotateImages($batchRequest);

            // 解析標籤
            foreach ($response->getResponses()[0]->getLabelAnnotations() as $label) {
                $descriptions[] = $label->getDescription();
            }

            $textAnalysis = $this->textAnalysisService->analyze(implode(',', $descriptions));
        } catch (\Exception $e) {
            // 處理錯誤
            return response()->json([
                'error' => `Failed to analyze image: {$e->getMessage()}`,
            ], 500);
        } finally {
            // 關閉 API 客戶端
            $imageAnnotator->close();
        }

        // 回傳 JSON 結果
        return response()->json([
            'labels' => $descriptions,
            'textAnalysis' => $textAnalysis
        ]);
    }
}
