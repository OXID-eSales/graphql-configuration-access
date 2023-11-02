<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum;

abstract class AbstractEnum
{
    protected static array $enums;

    public static function validateFieldType(string $type): bool
    {
        if (in_array($type, static::$enums)) {
            return true;
        }

        return false;
    }

    public static function getEnums(): array
    {
        return static::$enums;
    }
}
