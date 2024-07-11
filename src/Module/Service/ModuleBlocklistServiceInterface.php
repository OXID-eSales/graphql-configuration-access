<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;

interface ModuleBlocklistServiceInterface
{
    /**
     * @throws ModuleBlockListException
     */
    public function isModuleBlocked(string $moduleId): bool;
}
