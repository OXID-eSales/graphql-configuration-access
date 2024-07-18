<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;

final class ThemeListService implements ThemeListServiceInterface
{
    public function __construct(
        private readonly ThemeListInfrastructureInterface $themeListInfrastructure,
        private readonly ThemeFilterServiceInterface $themeFilterService
    ) {
    }

    /**
     * @return ThemeDataType[]
     */
    public function getThemeList(ThemeFiltersInterface $filters): array
    {
        $themesArray = $this->themeListInfrastructure->getThemes();
        return $this->themeFilterService->filterThemes($themesArray, $filters);
    }
}
