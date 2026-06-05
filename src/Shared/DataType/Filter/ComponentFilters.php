<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\FilterInterface;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use TheCodingMachine\GraphQLite\Annotations\Factory;

class ComponentFilters implements ComponentFiltersInterface
{
    private array $filters = [];

    public function __construct(
        ?StringFilter $titleFilter = null,
        ?BoolFilter $activeFilter = null
    ) {
        $this->addFilter($titleFilter, fn(ComponentDataTypeInterface $c) => $c->getTitle());
        $this->addFilter($activeFilter, fn(ComponentDataTypeInterface $c) => $c->isActive());
    }

    private function addFilter(?FilterInterface $filter, callable $getterMethod): void
    {
        if (!$filter) {
            return;
        }

        $filterForField = [
            'filter' => $filter,
            'accessor' => $getterMethod,
        ];
        $this->filters[] = $filterForField;
    }

    public function filterComponent(ComponentDataTypeInterface $component): bool
    {
        foreach ($this->filters as $filter) {
            if (!$filter['filter']->matches($filter['accessor']($component))) {
                return false;
            }
        }
        return true;
    }

    #[Factory(name: 'ComponentFilters', default: true)]
    public static function createComponentFilters(
        ?StringFilter $title = null,
        ?BoolFilter $active = null
    ): self {
        return new self(titleFilter: $title, activeFilter: $active);
    }
}
