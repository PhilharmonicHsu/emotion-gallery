<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

/**
 *
 *
 * @property int $id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnalysisResult whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AnalysisResult extends Model
{
    use HasFactory;

    protected $table = 'analysis_results';

    protected $fillable = [
        'id',
        'data',
        'created_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 格式化日期输出为 "Y-m-d H:i:s"
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
