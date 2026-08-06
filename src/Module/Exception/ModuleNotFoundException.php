<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

final class ModuleNotFoundException extends NotFound
{
    public function __construct(string $moduleId)
    {
        $message = sprintf('Module was not found: %s', $moduleId);

        parent::__construct($message);
    }
}
