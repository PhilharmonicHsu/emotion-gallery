<?php

namespace App\Http\Repository;

use App\Models\AnalysisResult;
use Illuminate\Support\Collection;

class AnalysisResultRepository
{
    public function create($data): AnalysisResult
    {
        return AnalysisResult::create(['data' => $data]);
    }

    public function getListOrderByCreatedAt(int $limit): Collection
    {
        return AnalysisResult::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
