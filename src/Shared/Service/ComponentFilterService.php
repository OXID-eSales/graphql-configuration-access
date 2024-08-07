<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;

class ComponentFilterService implements ComponentFilterServiceInterface
{
    public function filterComponents(array $components, ComponentFiltersInterface $filterList): array
    {
        return array_filter($components, function (ComponentDataTypeInterface $module) use ($filterList) {
            return $filterList->filterComponent($module);
        });
    }
}
