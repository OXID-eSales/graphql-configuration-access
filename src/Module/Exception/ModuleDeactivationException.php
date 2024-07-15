<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

final class ModuleDeactivationException extends NotFound
{
    private const EXCEPTION_MESSAGE = "An error occurred while deactivating the module.";
    public const BLOCKED_MODULE_MESSAGE = 'Module "%s" is in the blocklist and cannot be deactivated.';

    public function __construct(string $message = null)
    {
        if (empty($message)) {
            $message = self::EXCEPTION_MESSAGE;
        }
        parent::__construct($message);
    }
}
