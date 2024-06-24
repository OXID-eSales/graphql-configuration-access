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
    public function __construct(
        private readonly CoreThemeFactoryInterface $coreThemeFactory
    ) {
    }

    public function switchTheme(string $identifier): bool
    {
        try {
            $coreThemeService = $this->coreThemeFactory->getClass();
            if (!$coreThemeService->load($identifier)) {
                throw new ThemeActivationException(ThemeActivationException::THEME_NOT_EXIST);
            }
            $coreThemeService->activate();

            return true;
        } catch (ThemeActivationException | StandardException $e) {
            throw new ThemeActivationException($e->getMessage());
        }
    }
}
