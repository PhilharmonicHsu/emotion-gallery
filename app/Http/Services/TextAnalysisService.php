<?php

namespace App\Http\Services;

use App\Enums\EntityType;
use App\Enums\MentionType;
use Google\Cloud\Language\V2\AnalyzeEntitiesRequest;
use Google\Cloud\Language\V2\AnalyzeSentimentRequest;
use Google\Cloud\Language\V2\Client\LanguageServiceClient;
use Google\Cloud\Language\V2\Document;
use Illuminate\Http\JsonResponse;

class TextAnalysisService
{
    public function analyze(String $text): JsonResponse
    {
        // 初始化 LanguageServiceClient
        $languageServiceClient = new LanguageServiceClient();

        // 創建 Document 對象
        $document = new Document([
            'content' => $text,
            'type' => Document\Type::PLAIN_TEXT,
        ]);

        // 情感分析請求
        $sentimentRequest = new AnalyzeSentimentRequest([
            'document' => $document,
        ]);
        $sentimentResponse = $languageServiceClient->analyzeSentiment($sentimentRequest);

        // 獲取情感分析結果
        $sentiment = $sentimentResponse->getDocumentSentiment();

        // 實體分析請求
        $entityRequest = new AnalyzeEntitiesRequest([
            'document' => $document,
        ]);
        $entityResponse = $languageServiceClient->analyzeEntities($entityRequest);

        // 解析實體結果
        $entities = [];
        foreach ($entityResponse->getEntities() as $entity) {
            $mentions = [];
            $score = 0;
            foreach ($entity->getMentions() as $mention) {
                $mentions[] = [
                    'text' => $mention->getText()->getContent(),
                    'int_type' => $mention->getType(),
                    'type' => MentionType::getTypeById($mention->getType()),
                ];
                $score +=  MentionType::isProper($mention->getType()) ? 2 : 1;
            }

            $entities[] = [
                'name' => $entity->getName(),
                'type' => EntityType::getTypeById($entity->getType()),
                'importance' => $score,
                'mentions' => $mentions,
            ];
        }

        // 關閉客戶端
        $languageServiceClient->close();

        $score = $sentiment->getScore();
        $emotion = match(true) {
            $score > 0 => 'Positive',
            $score < 0 => 'Negative',
            default => 'Neutral',
        };

        /** 返回結果
         * score: 判斷情感方向
         * - 正面情感：score > 0
         * - 中立情感：score = 0
         * - 負面情感：score < 0
         *
         * magnitude: 判斷情感強度
         * - 情感強烈：magnitude > 1
         * - 情感較弱：magnitude <= 1
         */
        return response()->json([
            'sentiment' => [
                'score' => $score,
                'magnitude' => $sentiment->getMagnitude(), // 表示情感的強烈程度 情感強烈：magnitude > 1。
                'emotion' => $emotion
            ],
            'entities' => $entities,
        ]);
    }
}
