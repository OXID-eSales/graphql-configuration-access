<?php

/**
* Copyright © OXID eSales AG. All rights reserved.
* See LICENSE file for license details.
*/

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class ThemeListController
{
    public function __construct(
        private readonly ThemeListServiceInterface $themeListService
    ) {
    }

    /**
     * Query of Configuration Access Module
     * @return ThemeDataTypeInterface[]
     */
    #[Query]
    #[Logged]
    #[Right('LIST_THEMES')]
    public function themesList(?ComponentFilters $filters): array
    {
        return $this->themeListService->getThemeList($filters ?? new ComponentFilters());
    }
}
