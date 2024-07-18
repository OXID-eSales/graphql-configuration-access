<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use TheCodingMachine\GraphQLite\Annotations\Factory;

final class ThemeFilters implements ThemeFiltersInterface
{
    public function __construct(
        private readonly ?StringFilter $titleFilter = null,
        private readonly ?BoolFilter $activeFilter = null
    ) {
    }


    public function filterThemeByTitle(ThemeDataType $theme): bool
    {
        $titleFilter = $this->titleFilter;
        if ($titleFilter !== null && $titleFilter->contains() !== null) {
            if (!str_contains($theme->getTitle(), $titleFilter->contains())) {
                return false;
            }
        }
        return true;
    }

    public function filterThemeByStatus(ThemeDataType $theme): bool
    {
        $statusFilter = $this->activeFilter;
        if ($statusFilter !== null && $statusFilter->equals() !== null) {
            if ($theme->isActive() !== $statusFilter->equals()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Factory(name="ThemeFilters", default=true)
     */
    public static function createThemeFilters(
        ?StringFilter $title = null,
        ?BoolFilter $active = null
    ): self {
        return new self(titleFilter: $title, activeFilter: $active);
    }
}
