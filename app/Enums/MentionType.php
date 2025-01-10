<?php

namespace App\Enums;

enum MentionType: int {
    case TYPE_UNKNOWN = 0;
    case PROPER = 1;
    case COMMON = 2;

    public static function getTypeById(int $typeId): string
    {
        return match ($typeId) {
            self::PROPER->value => 'PROPER',
            self::COMMON->value => 'COMMON',
            default => 'TYPE_UNKNOWN',
        };
    }

    public static function isProper(int $typeId): bool
    {
        return $typeId === self::PROPER->value;
    }
}
