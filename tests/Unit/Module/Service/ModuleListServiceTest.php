<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\MetaData\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListService;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListService
 */
class ModuleListServiceTest extends UnitTestCase
{
    public function testGetModuleListWithFilters(): void
    {
        $filtersStub = $this->createStub(ModuleFiltersInterface::class);
        $moduleStub1 = $this->createStub(ModuleDataType::class);
        $moduleStub2 = $this->createStub(ModuleDataType::class);
        $filteredModules = [$moduleStub1];

        $moduleListInfrastructureMock = $this->createMock(ModuleListInfrastructureInterface::class);
        $moduleListInfrastructureMock->expects($this->once())->method('getModuleList')
            ->willReturn([$moduleStub1, $moduleStub2]);

        $moduleFilterServiceMock = $this->createMock(ModuleFilterServiceInterface::class);

        $moduleFilterServiceMock->expects($this->once())
            ->method('filterModules')
            ->with([$moduleStub1, $moduleStub2], $filtersStub)
            ->willReturn($filteredModules);

        $moduleDataTypeFactoryMock = $this->createMock(ModuleDataTypeFactoryInterface::class);
        $moduleDataTypeFactoryMock
            ->method('createFromCoreModule')
            ->willReturnOnConsecutiveCalls($moduleDataTypeMock1, $moduleDataTypeMock2);

        $sut = $this->getSut(
            moduleListInfrastructureMock: $moduleListInfrastructureMock,
            moduleFilterServiceMock: $moduleFilterServiceMock,
            moduleDataTypeFactoryMock: $moduleDataTypeFactoryMock
        );

        $actualModules = $sut->getModuleList($filtersStub);
        $this->assertSame($filteredModules, $actualModules);
    }

    public function getSut(
        ?ModuleListInfrastructureInterface $moduleListInfrastructureMock = null,
        ?ModuleFilterServiceInterface $moduleFilterServiceMock = null,
        ?ModuleDataTypeFactoryInterface $moduleDataTypeFactoryMock = null
    ): ModuleListService {
        return new ModuleListService(
            $moduleListInfrastructureMock ?? $this->createMock(ModuleListInfrastructureInterface::class),
            $moduleFilterServiceMock ?? $this->createMock(ModuleFilterServiceInterface::class),
            $moduleDataTypeFactoryMock ?? $this->createMock(ModuleDataTypeFactoryInterface::class)
        );
    }
}
