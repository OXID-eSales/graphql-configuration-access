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
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructure;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructure
 */
class ModuleListInfrastructureTest extends UnitTestCase
{
    public function testGetModuleList()
    {
        $moduleConfigurationStub = $this->createStub(ModuleConfiguration::class);
        $moduleDataType = $this->createStub(ModuleDataTypeInterface::class);

        $shopConfigurationMock = $this->createMock(ShopConfiguration::class);
        $shopConfigurationMock
            ->method('getModuleConfigurations')
            ->willReturn([$moduleConfigurationStub]);

        $shopConfigurationDaoBridgeMock = $this->createMock(ShopConfigurationDaoBridgeInterface::class);
        $shopConfigurationDaoBridgeMock->method('get')
            ->willReturn($shopConfigurationMock);

        $moduleDataTypeFactoryMock = $this->createMock(ModuleDataTypeFactoryInterface::class);
        $moduleDataTypeFactoryMock->method('createFromModuleConfiguration')
            ->with($moduleConfigurationStub)
            ->willReturn($moduleDataType);

        $sut = $this->getSut(
            shopConfigurationDaoBridgeMock: $shopConfigurationDaoBridgeMock,
            moduleDataTypeFactory: $moduleDataTypeFactoryMock
        );

        $result = $sut->getModuleList();

        $this->assertSame([$moduleDataType], $result);
    }

    public function testGetModuleListThrowsException()
    {
        $shopConfigurationDaoBridgeMock = $this->createMock(ShopConfigurationDaoBridgeInterface::class);
        $shopConfigurationDaoBridgeMock->method('get')
            ->willReturn($this->createMock(ShopConfiguration::class));

        $this->expectException(ModulesNotFoundException::class);

        $sut = $this->getSut(
            shopConfigurationDaoBridgeMock: $shopConfigurationDaoBridgeMock
        );

        $sut->getModuleList();
    }

    public function getSut(
        ?ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridgeMock = null,
        ?ModuleDataTypeFactoryInterface $moduleDataTypeFactory = null
    ): ModuleListInfrastructure {
        return new ModuleListInfrastructure(
            shopConfigurationDaoBridge: $shopConfigurationDaoBridgeMock ??
                $this->createStub(ShopConfigurationDaoBridgeInterface::class),
            moduleDataTypeFactory: $moduleDataTypeFactory ?? $this->createStub(ModuleDataTypeFactoryInterface::class)
        );
    }
}
