<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleListController;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleListController
 */
class ModuleListControllerTest extends UnitTestCase
{
    public function testModulesListWithFilters(): void
    {
        $filtersMock = $this->createMock(ModuleFilters::class);
        $moduleMock1 = $this->createMock(ModuleDataType::class);
        $moduleMock2 = $this->createMock(ModuleDataType::class);
        $filteredModules = [$moduleMock1, $moduleMock2];

        $moduleListServiceMock = $this->createMock(ModuleListServiceInterface::class);
        $moduleListServiceMock
            ->method('getModuleList')
            ->with($filtersMock)
            ->willReturn($filteredModules);

        $sut = new ModuleListController($moduleListServiceMock);
        $actualModules = $sut->modulesList($filtersMock);

        $this->assertSame($filteredModules, $actualModules);
    }

    public function testModulesListWithoutFilters(): void
    {
        $filtersMock = $this->createMock(ModuleFilters::class);
        $moduleMock1 = $this->createMock(ModuleDataType::class);
        $moduleMock2 = $this->createMock(ModuleDataType::class);
        $expectedModules = [$moduleMock1, $moduleMock2];

        $moduleListServiceMock = $this->createMock(ModuleListServiceInterface::class);
        $moduleListServiceMock
            ->method('getModuleList')
            ->with($filtersMock)
            ->willReturn($expectedModules);

        $sut = new ModuleListController($moduleListServiceMock);
        $actualModules = $sut->modulesList($filtersMock);

        $this->assertSame($expectedModules, $actualModules);
    }
}
