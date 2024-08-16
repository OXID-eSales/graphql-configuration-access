<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\Error;

final class ModuleDeactivationException extends Error
{
    private const EXCEPTION_MESSAGE = "An error occurred while deactivating the module.";

    public function __construct()
    {
        parent::__construct(self::EXCEPTION_MESSAGE);
    }
}
