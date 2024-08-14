<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSwitchInfrastructureInterface;

final class ThemeSwitchService implements ThemeSwitchServiceInterface
{
    public function __construct(
        private readonly ThemeSwitchInfrastructureInterface $themeSwitchInfrastructure
    ) {
    }
    public function switchTheme(string $themeId): bool
    {
        return $this->themeSwitchInfrastructure->switchTheme(themeId: $themeId);
    }
}
