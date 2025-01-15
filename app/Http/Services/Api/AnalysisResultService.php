<?php

namespace App\Http\Services\Api;

use App\Http\Repository\AnalysisResultRepository;
use App\Http\Services\ImageAnalysisService;
use App\Models\AnalysisResult;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AnalysisResultService
{
    private AnalysisResultRepository $analysisResultRepository;

    public function __construct(AnalysisResultRepository $analysisResultRepository)
    {
        $this->analysisResultRepository = $analysisResultRepository;
    }

    public function createAnalysisResult(array $analysisResult): AnalysisResult
    {
        return $this->analysisResultRepository->create($analysisResult);
    }

    public function getRecentAnalysisResults(): Collection
    {
        return $this->analysisResultRepository->getListOrderByCreatedAt(30);
    }
}
