<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeInterface;

interface ThemeListServiceInterface
{
    /**
     * @return ThemeDataTypeInterface[]
     */
    public function getThemeList(ComponentFiltersInterface $filters): array;
}
