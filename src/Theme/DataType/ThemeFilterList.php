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

final class ThemeFilterList implements ThemeFilterListInterface
{
    public function __construct(
        private readonly ?StringFilter $title = null,
        private readonly ?BoolFilter $active = null
    ) {
    }


    public function filterThemeByTitle(ThemeDataType $theme): bool
    {
        $titleFilter = $this->title;
        if ($titleFilter !== null && $titleFilter->contains() !== null) {
            if (!str_contains($theme->getTitle(), $titleFilter->contains())) {
                return false;
            }
        }
        return true;
    }

    public function filterThemeByStatus(ThemeDataType $theme): bool
    {
        $statusFilter = $this->active;
        if ($statusFilter !== null && $statusFilter->equals() !== null) {
            if ($theme->isActive() !== $statusFilter->equals()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Factory(name="ThemeFilterList", default=true)
     */
    public static function createThemeFilterList(
        ?StringFilter $title = null,
        ?BoolFilter $active = null
    ): self {
        return new self($title, $active);
    }
}
