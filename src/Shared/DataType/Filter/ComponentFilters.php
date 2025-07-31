<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use TheCodingMachine\GraphQLite\Annotations\Factory;

class ComponentFilters implements ComponentFiltersInterface
{
    private array $filters = [];

    public function __construct(
        ?TitleFilter $titleFilter = null,
        ?ActiveFilter $activeFilter = null
    ) {
        if ($titleFilter) {
            $this->filters[] = $titleFilter;
        }
        if ($activeFilter) {
            $this->filters[] = $activeFilter;
        }
    }

    public function filterComponent(ComponentDataTypeInterface $component): bool
    {
        foreach ($this->filters as $filter) {
            if (!$filter->componentMatches($component)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Factory(name="ComponentFilters", default=true)
     */
    public static function createComponentFilters(
        ?TitleFilter $title = null,
        ?ActiveFilter $active = null
    ): self {
        return new self(titleFilter: $title, activeFilter: $active);
    }
}
