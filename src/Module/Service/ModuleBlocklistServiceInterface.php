<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

interface ModuleBlocklistServiceInterface
{
    public function isModuleBlocked(string $moduleId): bool;
}
