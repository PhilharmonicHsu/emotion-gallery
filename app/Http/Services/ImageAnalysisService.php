<?php

namespace App\Http\Services;

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Illuminate\Http\Request;
use OpenAI;

class ImageAnalysisService
{
    private TextAnalysisService $textAnalysisService;

    public function __construct(TextAnalysisService $textAnalysisService) {
        $this->textAnalysisService = $textAnalysisService;
    }

    public function analyze(Request $request): array
    {
        // 取得圖片檔案路徑
        $imagePath = $request->file('image')->getRealPath();

        // 初始化 ImageAnnotatorClient
        $imageAnnotator = new ImageAnnotatorClient();
        $descriptions = [];
        $sentence = '';
        $sentiment = [];

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

            // 構建 GPT 輸入提示
            $prompt = $this->buildPrompt($descriptions);

            // 使用 OpenAI API 調用 GPT 模型
            $client = OpenAI::client(env('OPENAI_API_KEY'));
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo', // GPT 模型
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a creative assistant who can generate 20-word vivid descriptions based on provided image tags.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => 50,
                'temperature' => 0.7,
            ]);

            // 解析 GPT 的輸出
            $sentence = $response['choices'][0]['message']['content'];

            // 進行情感分析
            $sentiment = $this->textAnalysisService->analyze($sentence);
        } catch (\Exception $e) {
            // 處理錯誤
            return [
                'error' => `Failed to analyze image: {$e->getMessage()}`,
            ];
        } finally {
            // 關閉 API 客戶端
            $imageAnnotator->close();
        }

        // 回傳 JSON 結果
        return [
            'labels' => $descriptions,
            'sentence' => $sentence,
            'sentiment' => $sentiment
        ];
    }

    /**
     * 构建 GPT 输入提示
     */
    private function buildPrompt(array $labels): string
    {
        $labelList = implode(", ", $labels);
        return "Based on the following image labels: $labelList, generate a vivid and creative description of the image.";
    }
}
