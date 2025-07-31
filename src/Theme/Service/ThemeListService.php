<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;

final class ThemeListService implements ThemeListServiceInterface
{
    public function __construct(
        private readonly ThemeListInfrastructureInterface $themeListInfrastructure,
        private readonly ComponentFilterServiceInterface $componentFilterService
    ) {
    }

    public function getThemeList(ComponentFiltersInterface $filters): array
    {
        $themeDataTypes = $this->themeListInfrastructure->getThemes();

        return $this->componentFilterService->filterComponents($themeDataTypes, $filters);
    }
}
