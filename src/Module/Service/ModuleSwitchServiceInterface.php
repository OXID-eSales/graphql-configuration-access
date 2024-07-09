<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

interface ModuleSwitchServiceInterface
{
    public function activateModule(string $moduleId): bool;
    public function deactivateModule(string $moduleId): bool;
}
