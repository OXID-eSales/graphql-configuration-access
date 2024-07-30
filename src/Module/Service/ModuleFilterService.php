<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;

class ModuleFilterService implements ModuleFilterServiceInterface
{
    public function filterModules(array $modules, ModuleFiltersInterface $filterList): array
    {
        return array_filter($modules, function (ModuleDataTypeInterface $module) use ($filterList) {
            return $filterList->filterModuleByTitle(module: $module)
                && $filterList->filterModuleByStatus(module: $module);
        });
    }
}
