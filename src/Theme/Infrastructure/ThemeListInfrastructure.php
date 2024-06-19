<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;

final class ThemeListInfrastructure implements ThemeListInfrastructureInterface
{
    public function __construct(
        private readonly CoreThemeFactoryInterface $coreThemeFactory,
        private readonly ThemeDataTypeFactoryInterface $themeDataTypeFactory
    ) {
    }

    public function getThemes(): array
    {
        $coreThemeService = $this->coreThemeFactory->getClass();
        $themesList = $coreThemeService->getList();

        if (empty($themesList)) {
            throw new ThemesNotFound();
        }

        $themesArray = [];
        foreach ($themesList as $theme) {
            $themesArray[] = $this->themeDataTypeFactory->createFromCoreTheme(theme: $theme);
        }

        return $themesArray;
    }
}
