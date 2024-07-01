<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;

interface ModuleFiltersInterface
{
    public function filterModuleByTitle(ModuleDataType $module): bool;
    public function filterModuleByStatus(ModuleDataType $module): bool;
    public static function createModuleFilters(
        ?StringFilter $titleFilter = null,
        ?BoolFilter $activeFilter = null
    ): ModuleFilters;
}
