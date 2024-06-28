<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;

interface ThemeFiltersInterface
{
    public function filterThemeByTitle(ThemeDataType $theme): bool;
    public function filterThemeByStatus(ThemeDataType $theme): bool;
    public static function createThemeFilters(
        ?StringFilter $titleFilter,
        ?BoolFilter $activeFilter
    ): ThemeFilters;
}
