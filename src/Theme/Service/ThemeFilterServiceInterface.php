<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterListInterface;

interface ThemeFilterServiceInterface
{
    /**
     * @param array<ThemeDataType> $themes
     * @param ThemeFilterListInterface $filterList
     * @return array<ThemeDataType>
     */
    public function filterThemes(array $themes, ThemeFilterListInterface $filterList): array;
}
