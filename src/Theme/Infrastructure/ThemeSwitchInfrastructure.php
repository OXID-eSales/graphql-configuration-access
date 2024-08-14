<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeActivationException;

final class ThemeSwitchInfrastructure implements ThemeSwitchInfrastructureInterface
{
    private const THEME_NOT_EXIST = "The specified theme doesn't exist.";

    public function __construct(
        private readonly CoreThemeFactoryInterface $coreThemeFactory
    ) {
    }

    public function switchTheme(string $themeId): bool
    {
        try {
            $coreThemeService = $this->coreThemeFactory->create();
            if (!$coreThemeService->load($themeId)) {
                throw new ThemeActivationException(self::THEME_NOT_EXIST);
            }
            $coreThemeService->activate();

            return true;
        } catch (ThemeActivationException | StandardException $e) {
            throw new ThemeActivationException($e->getMessage());
        }
    }
}
