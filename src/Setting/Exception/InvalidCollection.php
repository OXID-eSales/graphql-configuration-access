<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception;

use Exception;

final class InvalidCollection extends Exception
{
    public static function byCollectionString(string $value): self
    {
        return new self(sprintf('%s is not a valid collection string.', $value));
    }
}
