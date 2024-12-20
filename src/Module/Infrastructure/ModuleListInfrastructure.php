<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;

class ModuleListInfrastructure implements ModuleListInfrastructureInterface
{
    public function __construct(
        private readonly ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridge,
        private readonly ModuleDataTypeFactoryInterface $moduleDataTypeFactory
    ) {
    }

    public function getModuleList(): array
    {
        $shopConfiguration = $this->shopConfigurationDaoBridge->get();
        $moduleConfigurations = $shopConfiguration->getModuleConfigurations();

        if (empty($moduleConfigurations)) {
            throw new ModulesNotFoundException();
        }

        $moduleDatatypes = [];
        foreach ($moduleConfigurations as $moduleConfig) {
            $moduleDatatypes[] = $this->moduleDataTypeFactory->createFromModuleConfiguration($moduleConfig);
        }
        return $moduleDatatypes;
    }
}
