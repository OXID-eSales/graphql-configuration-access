<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterListInterface;

class ThemeFilterService implements ThemeFilterServiceInterface
{
    public function filterThemes(array $themes, ThemeFilterListInterface $filterList): array
    {
        return array_filter($themes, function (ThemeDataType $theme) use ($filterList) {
            return $filterList->filterThemeByTitle($theme) && $filterList->filterThemeByStatus($theme);
        });
    }
}
