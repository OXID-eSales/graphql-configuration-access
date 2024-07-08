<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException;

interface ModuleSwitchInfrastructureInterface
{
    /**
     * @throws ModuleActivationException
     */
    public function activateModule(string $moduleId): bool;

    /**
     * @throws ModuleDeactivationException
     */
    public function deactivateModule(string $moduleId): bool;
}
