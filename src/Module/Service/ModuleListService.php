<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;

final class ModuleListService implements ModuleListServiceInterface
{
    public function __construct(
        private readonly ModuleListInfrastructureInterface $moduleListInfrastructure,
        private readonly ModuleFilterServiceInterface $moduleFilterService
    ) {
    }

    public function getModuleList(ModuleFiltersInterface $filters): array
    {
        $modulesArray = $this->moduleListInfrastructure->getModuleList();
        return $this->moduleFilterService->filterModules($modulesArray, $filters);
    }
}
