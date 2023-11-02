<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum;


final class DatabaseFieldType extends AbstractEnum
{
    public const ASSOCIATIVE_ARRAY = 'aarr';
    public const NUMBER = 'num';
    public const ARRAY = 'arr';
    public const STRING = 'str';
    public const BOOLEAN = 'bool';
    public const SELECT = 'select';

    protected static array $enums = [
        self::ASSOCIATIVE_ARRAY,
        self::NUMBER,
        self::ARRAY,
        self::STRING,
        self::BOOLEAN,
        self::SELECT
    ];
}
