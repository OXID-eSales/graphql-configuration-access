<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use TheCodingMachine\GraphQLite\Annotations\Factory;

class ComponentFilters implements ComponentFiltersInterface
{
    public function __construct(
        private readonly ?StringFilter $titleFilter = null,
        private readonly ?BoolFilter $activeFilter = null
    ) {
    }

    private function filterComponentByTitle(string $title): bool
    {
        $titleFilter = $this->titleFilter;
        if ($titleFilter !== null) {
            return $titleFilter->matches($title);
        }

        return true;
    }

    private function filterComponentByStatus(bool $status): bool
    {
        $statusFilter = $this->activeFilter;
        if ($statusFilter !== null && $status !== $statusFilter->equals()) {
            return false;
        }

        return true;
    }

    public function filterComponent(ComponentDataTypeInterface $component): bool
    {
        return $this->filterComponentByTitle($component->getTitle())
            && $this->filterComponentByStatus($component->isActive());
    }

    /**
     * @Factory(name="ComponentFilters", default=true)
     */
    public static function createComponentFilters(
        ?StringFilter $title = null,
        ?BoolFilter $active = null
    ): self {
        return new self(titleFilter: $title, activeFilter: $active);
    }
}
