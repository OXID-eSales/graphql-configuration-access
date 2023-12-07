<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum;

final class FieldType
{
    public const ASSOCIATIVE_ARRAY = 'aarr';
    public const NUMBER = 'num';
    public const ARRAY = 'arr';
    public const STRING = 'str';
    public const BOOLEAN = 'bool';
    public const SELECT = 'select';

    private static array $enums = [
        self::ASSOCIATIVE_ARRAY,
        self::NUMBER,
        self::ARRAY,
        self::STRING,
        self::BOOLEAN,
        self::SELECT
    ];

    public static function validateFieldType(string $type): bool
    {
        if (in_array($type, self::$enums)) {
            return true;
        }

        return false;
    }

    public static function getEnums(): array
    {
        return self::$enums;
    }
}
