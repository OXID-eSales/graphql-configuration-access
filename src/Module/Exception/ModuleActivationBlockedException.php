<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

final class ModuleActivationBlockedException extends NotFound
{
    private const EXCEPTION_MESSAGE = 'Module "%s" is in the blocklist and cannot be activated.';

    public function __construct(string $moduleId)
    {
        parent::__construct(sprintf(self::EXCEPTION_MESSAGE, $moduleId));
    }
}
