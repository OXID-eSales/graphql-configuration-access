<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFiltersInterface;

interface ThemeListServiceInterface
{
    /**
     * @return ThemeDataType[]
     */
    public function getThemeList(ThemeFiltersInterface $filters): array;
}
