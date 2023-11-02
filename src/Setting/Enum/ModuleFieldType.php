<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum;


final class ModuleFieldType extends AbstractEnum
{
    public const INTEGER = 'int';
    public const FLOAT = 'float';
    public const BOOLEAN = 'bool';
    public const STRING = 'str';
    public const ARRAY = 'arr';

    protected static array $enums = [
        self::INTEGER,
        self::FLOAT,
        self::BOOLEAN,
        self::STRING,
        self::ARRAY
    ];
}
