<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;

interface CoreThemeFactoryInterface
{
    /**
     * @return Theme
     */
    public function create(): Theme;
}
