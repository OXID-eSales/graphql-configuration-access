<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;

interface ModuleFilterServiceInterface
{
    /**
     * @param array<ModuleDataType> $modules
     * @param ModuleFiltersInterface $filterList
     * @return array<ModuleDataType>
     */
    public function filterModules(array $modules, ModuleFiltersInterface $filterList): array;
}
