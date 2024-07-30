<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;

final class ModuleListService implements ModuleListServiceInterface
{
    public function __construct(
        private readonly ModuleListInfrastructureInterface $moduleListInfrastructure,
        private readonly ModuleFilterServiceInterface $moduleFilterService,
        private readonly ModuleDataTypeFactoryInterface $moduleDataTypeFactory
    ) {
    }

    public function getModuleList(ModuleFiltersInterface $filters): array
    {
        $modulesArray = [];
        $moduleConfigurations = $this->moduleListInfrastructure->getModuleList();
        foreach ($moduleConfigurations as $moduleConfig) {
            $modulesArray[] = $this->moduleDataTypeFactory->createFromCoreModule($moduleConfig);
        }
        return $this->moduleFilterService->filterModules($modulesArray, $filters);
    }
}
