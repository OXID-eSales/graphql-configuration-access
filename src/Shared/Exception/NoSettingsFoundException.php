<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

class NoSettingsFoundException extends NotFound
{
    public function __construct(string $message = 'No settings found')
    {
        parent::__construct($message);
    }
}
