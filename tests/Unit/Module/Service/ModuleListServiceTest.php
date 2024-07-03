<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListService;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListService
 */
class ModuleListServiceTest extends UnitTestCase
{
    public function testGetModuleListWithFilters(): void
    {
        $filtersMock = $this->createMock(ModuleFiltersInterface::class);
        $moduleMock1 = $this->createMock(ModuleDataType::class);
        $moduleMock2 = $this->createMock(ModuleDataType::class);
        $filteredModules = [$moduleMock1];

        $moduleListInfrastructureMock = $this->createMock(ModuleListInfrastructureInterface::class);
        $moduleListInfrastructureMock->method('getModuleList')
            ->willReturn([$moduleMock1, $moduleMock2]);

        $moduleFilterServiceMock = $this->createMock(ModuleFilterServiceInterface::class);

        $moduleFilterServiceMock
            ->method('filterModules')
            ->with([$moduleMock1, $moduleMock2], $filtersMock)
            ->willReturn($filteredModules);

        $sut = $this->getSut(
            moduleListInfrastructureMock: $moduleListInfrastructureMock,
            moduleFilterServiceMock: $moduleFilterServiceMock
        );

        $actualModules = $sut->getModuleList($filtersMock);
        $this->assertSame($filteredModules, $actualModules);
    }

    public function testGetModuleListNoModules(): void
    {
        $filtersMock = $this->createMock(ModuleFiltersInterface::class);
        $moduleListInfrastructureMock = $this->createMock(ModuleListInfrastructureInterface::class);
        $moduleFilterServiceMock = $this->createMock(ModuleFilterServiceInterface::class);

        $moduleFilterServiceMock
            ->method('filterModules')
            ->with([], $filtersMock)
            ->willReturn([]);

        $sut = $this->getSut(
            moduleListInfrastructureMock: $moduleListInfrastructureMock,
            moduleFilterServiceMock: $moduleFilterServiceMock
        );

        $actualModules = $sut->getModuleList($filtersMock);
        $this->assertSame([], $actualModules);
    }

    public function getSut(
        ?ModuleListInfrastructureInterface $moduleListInfrastructureMock = null,
        ?ModuleFilterServiceInterface $moduleFilterServiceMock = null
    ): ModuleListService {
        return new ModuleListService(
            $moduleListInfrastructureMock ?? $this->createMock(ModuleListInfrastructureInterface::class),
            $moduleFilterServiceMock ?? $this->createMock(ModuleFilterServiceInterface::class)
        );
    }
}
