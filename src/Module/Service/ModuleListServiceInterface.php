<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFiltersInterface;

interface ModuleListServiceInterface
{
    /**
     * @return array<ModuleDataTypeInterface>
     */
    public function getModuleList(ComponentFiltersInterface $filters): array;
}
