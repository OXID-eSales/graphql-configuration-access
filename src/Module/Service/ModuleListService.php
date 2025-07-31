<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;

final class ModuleListService implements ModuleListServiceInterface
{
    public function __construct(
        private readonly ModuleListInfrastructureInterface $moduleListInfrastructure,
        private readonly ComponentFilterServiceInterface $componentFilterService,
    ) {
    }

    public function getModuleList(ComponentFiltersInterface $filters): array
    {
        $moduleConfigurations = $this->moduleListInfrastructure->getModuleList();

        return $this->componentFilterService->filterComponents($moduleConfigurations, $filters);
    }
}
