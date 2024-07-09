<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleSwitchInfrastructureInterface;

class ModuleSwitchService implements ModuleSwitchServiceInterface
{
    public function __construct(
        private readonly ModuleSwitchInfrastructureInterface $moduleSwitchInfrastructure
    ) {
    }

    public function activateModule(string $moduleId): bool
    {
        return $this->moduleSwitchInfrastructure->activateModule(moduleId: $moduleId);
    }

    public function deactivateModule(string $moduleId): bool
    {
        return $this->moduleSwitchInfrastructure->deactivateModule(moduleId: $moduleId);
    }
}
