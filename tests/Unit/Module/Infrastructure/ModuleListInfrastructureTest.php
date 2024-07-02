<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructure;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructure
 */
class ModuleListInfrastructureTest extends UnitTestCase
{
    public function testGetModuleList()
    {
        $moduleConfigId = 'awesomeModule';
        $moduleConfigurationMock = $this->createMock(ModuleConfiguration::class);
        $moduleDataTypeMock = $this->createMock(ModuleDataType::class);

        $moduleDataTypeFactoryMock = $this->createMock(ModuleDataTypeFactoryInterface::class);
        $moduleDataTypeFactoryMock
            ->method('createFromCoreModule')
            ->with($moduleConfigurationMock)
            ->willReturn($moduleDataTypeMock);

        $moduleConfigMock = $this->createMock(ModuleConfiguration::class);
        $moduleConfigMock
            ->method('getId')
            ->willReturn($moduleConfigId);

        $shopConfigurationMock = $this->createMock(ShopConfiguration::class);
        $shopConfigurationMock
            ->method('getModuleConfigurations')
            ->willReturn([$moduleConfigMock]);

        $shopConfigurationDaoBridgeMock = $this->createMock(ShopConfigurationDaoBridgeInterface::class);
        $shopConfigurationDaoBridgeMock
            ->method('get')
            ->willReturn($shopConfigurationMock);

        $sut = $this->getSut(
            moduleDataTypeFactoryMock: $moduleDataTypeFactoryMock,
            shopConfigurationDaoBridgeMock: $shopConfigurationDaoBridgeMock
        );

        $result = $sut->getModuleList();

        $this->assertCount(1, $result);
        $this->assertSame($moduleDataTypeMock, $result[0]);
    }

    public function testGetModuleListThrowsException()
    {
        $shopConfigurationDaoBridgeMock = $this->createMock(ShopConfigurationDaoBridgeInterface::class);
        $shopConfigurationDaoBridgeMock
            ->method('get')
            ->willReturn($this->createMock(ShopConfiguration::class));

        $this->expectException(ModulesNotFoundException::class);

        $sut = $this->getSut(
            shopConfigurationDaoBridgeMock: $shopConfigurationDaoBridgeMock
        );

        $sut->getModuleList();
    }

    public function getSut(
        ?ModuleDataTypeFactoryInterface $moduleDataTypeFactoryMock = null,
        ?ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridgeMock = null
    ): ModuleListInfrastructure {
        return new ModuleListInfrastructure(
            $moduleDataTypeFactoryMock ?? $this->createMock(ModuleDataTypeFactoryInterface::class),
            $shopConfigurationDaoBridgeMock ?? $this->createMock(ShopConfigurationDaoBridgeInterface::class)
        );
    }
}
