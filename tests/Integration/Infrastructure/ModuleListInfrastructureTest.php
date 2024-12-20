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
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
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
        $moduleConfiguration1->setTitle(['en' => 'Module 1']);
        $moduleConfiguration1->setDescription(['en' => 'Module 1 description']);
        $moduleConfiguration1->setLang('en');
        $moduleConfiguration1->setModuleSource('test');

        $moduleConfiguration2 = new ModuleConfiguration();
        $moduleConfiguration2->setId('secondModule');
        $moduleConfiguration2->setTitle(['en' => 'Module 2']);
        $moduleConfiguration2->setDescription(['en' => 'Module 2 description']);
        $moduleConfiguration2->setLang('en');
        $moduleConfiguration2->setModuleSource('test1');

        $shopConfiguration
            ->addModuleConfiguration($moduleConfiguration1)
            ->addModuleConfiguration($moduleConfiguration2);
        $shopConfigurationDaoBridge->save($shopConfiguration);

        $sut = $this->getSut();
        $modulesList = $sut->getModuleList();
        $this->assertCount(2, $modulesList);
        $this->assertInstanceOf(ModuleDataTypeInterface::class, $modulesList[0]);
        $this->assertInstanceOf(ModuleDataTypeInterface::class, $modulesList[1]);
        $this->assertSame($modulesList[0]->getId(), $moduleConfiguration1->getId());
        $this->assertSame($modulesList[1]->getId(), $moduleConfiguration2->getId());
    }

    public function getSut(): ModuleListInfrastructure
    {
        return new ModuleListInfrastructure(
            $this->get(ShopConfigurationDaoBridgeInterface::class),
            $this->get(ModuleDataTypeFactoryInterface::class)
        );
    }
}
