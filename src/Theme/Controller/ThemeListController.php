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
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterList;

final class ThemeListController
{
    public function __construct(
        private readonly ThemeListServiceInterface $themeListService
    ) {
    }

    /**
     * Query of Configuration Access Module
     * @param ThemeFilterList|null $filters
     * @return ThemeDataType[]
     */
    #[Query]
    #[Logged]
    public function themesList(?ThemeFilterList $filters = null): array
    {
        return $this->themeListService->getThemeList($filters ?? new ThemeFilterList());
    }
}
