<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;

interface ModuleListInfrastructureInterface
{
    /**
     * @return array<ModuleConfiguration>
     * @throws ModulesNotFoundException
     */
    public function getModuleList(): array;
}
