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
enum SourceType
{
    case SHOP;
    case MODULE;
    case THEME;

    //TODO
    public static function fromSourceId(string $sourceId): static
    {
        if ($sourceId) {
            return static::MODULE;
        }

        return static::SHOP;
    }
}
