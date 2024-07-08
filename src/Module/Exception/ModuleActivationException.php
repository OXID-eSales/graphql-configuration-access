<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

final class ModuleActivationException extends NotFound
{
    public const EXCEPTION_MESSAGE = "An error occurred while activating the module.";

    public function __construct()
    {
        parent::__construct(self::EXCEPTION_MESSAGE);
    }
}
