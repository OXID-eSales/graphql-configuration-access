<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\Eshop\Core\Theme;

interface ThemeDataTypeFactoryInterface
{
    public function createFromCoreTheme(Theme $theme): ThemeDataTypeInterface;
}
