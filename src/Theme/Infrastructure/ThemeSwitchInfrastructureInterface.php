<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeActivationException;

interface ThemeSwitchInfrastructureInterface
{
    /**
     *@throws ThemeActivationException
     */
    public function switchTheme(string $themeId): bool;
}
