<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;

class ModuleListInfrastructure implements ModuleListInfrastructureInterface
{
    public function __construct(
        private readonly ModuleDataTypeFactoryInterface $moduleDataTypeFactory,
        private readonly ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridge
    ) {
    }

    public function getModuleList(): array
    {
        $modules = [];
        $shopConfiguration = $this->shopConfigurationDaoBridge->get();
        $moduleConfigurations = $shopConfiguration->getModuleConfigurations();

        if (empty($moduleConfigurations)) {
            throw new ModulesNotFoundException();
        }

        foreach ($moduleConfigurations as $moduleConfig) {
            $modules[] = $this->moduleDataTypeFactory->createFromCoreModule($moduleConfig);
        }

        return $modules;
    }
}
