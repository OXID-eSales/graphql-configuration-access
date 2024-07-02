<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;

interface ModuleListInfrastructureInterface
{
    /**
     * @return array<ModuleDataType>
     *@throws ModulesNotFoundException
     */
    public function getModuleList(): array;
}
