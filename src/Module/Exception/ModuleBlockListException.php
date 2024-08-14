<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\Error;

final class ModuleBlockListException extends Error
{
    public const EXCEPTION_MESSAGE = "Failed to load module blocklist from YAML file.";

    public function __construct()
    {
        parent::__construct(self::EXCEPTION_MESSAGE);
    }
}
