<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use TheCodingMachine\GraphQLite\Annotations\Factory;

class ModuleFilters implements ModuleFiltersInterface
{
    public function __construct(
        private readonly ?StringFilter $titleFilter = null,
        private readonly ?BoolFilter $activeFilter = null
    ) {
    }

    public function filterModuleByTitle(ModuleDataType $module): bool
    {
        $titleFilter = $this->titleFilter;
        if ($titleFilter !== null && $module->getTitle() !== null) {
            return $titleFilter->matches($module->getTitle());
        }

        return true;
    }

    public function filterModuleByStatus(ModuleDataType $module): bool
    {
        $statusFilter = $this->activeFilter;
        if ($statusFilter !== null && $statusFilter->equals() !== null) {
            if ($module->isActive() !== $statusFilter->equals()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Factory(name="ModuleFilters", default=true)
     */
    public static function createModuleFilters(
        ?StringFilter $title = null,
        ?BoolFilter $active = null
    ): self {
        return new self(titleFilter: $title, activeFilter: $active);
    }
}
