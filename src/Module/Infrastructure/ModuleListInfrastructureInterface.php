<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;

interface ModuleListInfrastructureInterface
{
    /**
     * @throws ModulesNotFoundException
     * @return array<ModuleDataTypeInterface>
     */
    public function getModuleList(): array;
}
