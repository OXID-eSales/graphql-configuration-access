<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;

interface ModuleDataTypeFactoryInterface
{
    public function createFromModuleConfiguration(ModuleConfiguration $moduleConfig): ModuleDataTypeInterface;
}
