<?php

/**
* Copyright © OXID eSales AG. All rights reserved.
* See LICENSE file for license details.
*/

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilters;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class ThemeListController
{
    public function __construct(
        private readonly ThemeListServiceInterface $themeListService
    ) {
    }

    /**
     * Query of Configuration Access Module
     * @param ThemeFilters|null $filters
     * @return ThemeDataType[]
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function themesList(?ThemeFilters $filters): array
    {
        return $this->themeListService->getThemeList($filters ?? new ThemeFilters());
    }
}
