<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
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
        $moduleConfigurationMock = $this->createMock(ModuleConfiguration::class);

        $shopConfigurationMock = $this->createMock(ShopConfiguration::class);
        $shopConfigurationMock
            ->method('getModuleConfigurations')
            ->willReturn([$moduleConfigurationMock]);

        $shopConfigurationDaoBridgeMock = $this->createMock(ShopConfigurationDaoBridgeInterface::class);
        $shopConfigurationDaoBridgeMock
            ->method('get')
            ->willReturn($shopConfigurationMock);

        $sut = $this->getSut(
            shopConfigurationDaoBridgeMock: $shopConfigurationDaoBridgeMock
        );

        $result = $sut->getModuleConfigurations();

        $this->assertSame([$moduleConfigurationMock], $result);
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

        $sut->getModuleConfigurations();
    }

    public function getSut(
        ?ShopConfigurationDaoBridgeInterface $shopConfigurationDaoBridgeMock = null
    ): ModuleListInfrastructure {
        return new ModuleListInfrastructure(
            $shopConfigurationDaoBridgeMock ?? $this->createMock(ShopConfigurationDaoBridgeInterface::class)
        );
    }
}
