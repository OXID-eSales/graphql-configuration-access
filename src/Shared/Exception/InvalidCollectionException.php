<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception;

use Exception;

final class InvalidCollectionException extends Exception
{
    public function __construct(string $value)
    {
        parent::__construct(sprintf('%s is not a valid collection string.', $value));
    }
}
