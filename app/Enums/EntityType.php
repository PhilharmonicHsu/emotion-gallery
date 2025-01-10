<?php

namespace App\Enums;

enum EntityType: int {
    case PERSON = 1;
    case LOCATION = 2;
    case ORGANIZATION = 3;
    case EVENT = 4;
    case WORK_OF_ART = 5;
    case CONSUMER_GOOD = 6;
    case OTHER = 7;
    case PHONE_NUMBER = 8;
    case ADDRESS = 9;
    case DATE = 10;
    case NUMBER = 11;
    case PRICE = 12;

    public static function getTypeById(int $typeId): string {
        return match ($typeId) {
            self::PERSON->value => 'PERSON',
            self::LOCATION->value => 'LOCATION',
            self::ORGANIZATION->value => 'ORGANIZATION',
            self::EVENT->value => 'EVENT',
            self::WORK_OF_ART->value => 'WORK_OF_ART',
            self::CONSUMER_GOOD->value => 'CONSUMER_GOOD',
            self::OTHER->value => 'OTHER',
            self::PHONE_NUMBER->value => 'PHONE_NUMBER',
            self::ADDRESS->value => 'ADDRESS',
            self::DATE->value => 'DATE',
            self::NUMBER->value => 'NUMBER',
            self::PRICE->value => 'PRICE',
            default => 'UNKNOWN',
        };
    }
}

