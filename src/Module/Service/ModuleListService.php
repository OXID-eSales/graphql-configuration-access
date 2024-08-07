<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;

final class ModuleListService implements ModuleListServiceInterface
{
    public function __construct(
        private readonly ModuleListInfrastructureInterface $moduleListInfrastructure,
        private readonly ComponentFilterServiceInterface $componentFilterService,
        private readonly ModuleDataTypeFactoryInterface $moduleDataTypeFactory
    ) {
    }

    public function getModuleList(ComponentFiltersInterface $filters): array
    {
        $modulesArray = [];
        $moduleConfigurations = $this->moduleListInfrastructure->getModuleConfigurations();
        foreach ($moduleConfigurations as $moduleConfig) {
            $modulesArray[] = $this->moduleDataTypeFactory->createFromModuleConfiguration($moduleConfig);
        }

        return $this->componentFilterService->filterComponents($modulesArray, $filters);
    }
}
