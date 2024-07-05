<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructure;

class ModuleListInfrastructureTest extends IntegrationTestCase
{
    public function testGetModuleList()
    {
        $moduleConfigId = 'awesomeModuleId';
        $moduleConfigMock = $this->createMock(ModuleConfiguration::class);
        $moduleConfigMock
            ->method('getId')
            ->willReturn($moduleConfigId);
        $moduleConfigMock
            ->method('isActivated')
            ->willReturn(true);

        $shopConfigurationMock = $this->createMock(ShopConfiguration::class);
        $shopConfigurationMock
            ->method('getModuleConfigurations')
            ->willReturn([$moduleConfigMock]);

        $shopConfigurationDaoBridgeMock = $this->createMock(ShopConfigurationDaoBridgeInterface::class);
        $shopConfigurationDaoBridgeMock
            ->method('get')
            ->willReturn($shopConfigurationMock);

        $sut = $this->getSut(shopConfigurationDaoBridge: $shopConfigurationDaoBridgeMock);
        $modulesList = $sut->getModuleList();

        $this->assertIsArray($modulesList);
        $this->assertSame($moduleConfigId, $modulesList[0]->getId());
        $this->assertTrue($modulesList[0]->isActive());
    }

    public function getSut(
        ?ModuleDataTypeFactoryInterface $moduleDataTypeFactory = null,
        ?ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridge = null
    ): ModuleListInfrastructure {
        return new ModuleListInfrastructure(
            $moduleDataTypeFactory ?? $this->get(ModuleDataTypeFactoryInterface::class),
            $shopConfigurationDaoBridge ?? $this->get(ShopConfigurationDaoBridgeInterface::class)
        );
    }
}
