<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;

interface ThemeListInfrastructureInterface
{
    /**
     * @return array<Theme>
     * @throws ThemesNotFound
     */
    public function getThemes(): array;
}
