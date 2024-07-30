<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;

interface ModuleFilterServiceInterface
{
    /**
     * @param array<ModuleDataTypeInterface> $modules
     * @param ModuleFiltersInterface $filterList
     * @return array<ModuleDataTypeInterface>
     */
    public function filterModules(array $modules, ModuleFiltersInterface $filterList): array;
}
