<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum;

use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
enum FieldType
{
    case ASSOCIATIVE_ARRAY;
    case ARRAY;
    case BOOLEAN;
    case NUMBER;
    case STRING;
    case SELECT;

    public static function fromInternalType(string $type): static
    {
        return match($type) {
            'aarr' => static::ASSOCIATIVE_ARRAY,
            'arr' => static::ARRAY,
            'bool' => static::BOOLEAN,
            'num' => static::NUMBER,
            'str' => static::STRING,
            'select' => static::SELECT,
        };
    }
}
