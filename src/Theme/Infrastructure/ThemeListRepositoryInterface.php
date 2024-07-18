<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeNotFound;

interface ThemeListRepositoryInterface
{
    /**
     * @throws ThemeNotFound
     * @return array<ThemeDataType>
     */
    public function getThemes(): array;
}
