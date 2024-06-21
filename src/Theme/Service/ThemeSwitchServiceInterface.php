<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

interface ThemeSwitchServiceInterface
{
    public function switchTheme(string $identifier): bool;
}
