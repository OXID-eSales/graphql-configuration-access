<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;

final class ThemeListService implements ThemeListServiceInterface
{
    public function __construct(
        private readonly ThemeListInfrastructureInterface $themeListInfrastructure,
        private readonly ComponentFilterServiceInterface $componentFilterService,
        private readonly ThemeDataTypeFactoryInterface $themeDataTypeFactory
    ) {
    }

    public function getThemeList(ComponentFiltersInterface $filters): array
    {
        $themesArray =  [];
        $themesList = $this->themeListInfrastructure->getThemes();
        foreach ($themesList as $theme) {
            $themesArray[] = $this->themeDataTypeFactory->createFromCoreTheme(theme: $theme);
        }

        return $this->componentFilterService->filterComponents($themesArray, $filters);
    }
}
