<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;

interface ThemeListInfrastructureInterface
{
    /**
     * @return ThemeDataTypeInterface[]
     * @throws ThemesNotFound
     */
    public function getThemes(): array;
}
