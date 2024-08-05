<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructure;

class ModuleListInfrastructureTest extends IntegrationTestCase
{
    public function testGetModuleList()
    {
        /** @var ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridge */
        $shopConfigurationDaoBridge = $this->get(ShopConfigurationDaoBridgeInterface::class);
        $shopConfiguration = $shopConfigurationDaoBridge->get();

        $moduleConfiguration1 = new ModuleConfiguration();
        $moduleConfiguration1->setId('firstModule');
        $moduleConfiguration1->setModuleSource('test');

        $moduleConfiguration2 = new ModuleConfiguration();
        $moduleConfiguration2->setId('secondModule');
        $moduleConfiguration2->setModuleSource('test1');

        $shopConfiguration
            ->addModuleConfiguration($moduleConfiguration1)
            ->addModuleConfiguration($moduleConfiguration2);
        $shopConfigurationDaoBridge->save($shopConfiguration);

        $sut = new ModuleListInfrastructure(
            $shopConfigurationDaoBridge
        );
        $modulesList = $sut->getModuleList();
        $this->assertEquals([
            $moduleConfiguration1->getId() => $moduleConfiguration1,
            $moduleConfiguration2->getId() => $moduleConfiguration2
        ], $modulesList);
    }

    public function getSut(): ModuleListInfrastructure
    {
        return new ModuleListInfrastructure(
            $this->get(ShopConfigurationDaoBridgeInterface::class)
        );
    }
}
