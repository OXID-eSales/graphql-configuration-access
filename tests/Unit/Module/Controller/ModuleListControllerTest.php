<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleListController;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleListController
 */
class ModuleListControllerTest extends UnitTestCase
{
    public function testModulesListWithFilters(): void
    {
        $filtersStub = $this->createStub(ComponentFilters::class);
        $moduleStub1 = $this->createStub(ModuleDataTypeInterface::class);
        $moduleStub2 = $this->createStub(ModuleDataTypeInterface::class);
        $filteredModules = [$moduleStub1, $moduleStub2];

        $moduleListServiceMock = $this->createMock(ModuleListServiceInterface::class);
        $moduleListServiceMock->expects($this->once())
            ->method('getModuleList')
            ->with($filtersStub)
            ->willReturn($filteredModules);

        $sut = new ModuleListController($moduleListServiceMock);
        $actualModules = $sut->modules($filtersStub);

        $this->assertSame($filteredModules, $actualModules);
    }

    public function testModulesListWithoutFilters(): void
    {
        $moduleStub = $this->createStub(ModuleDataTypeInterface::class);
        $componentFilters = new ComponentFilters();

        $moduleListServiceSpy = $this->createMock(ModuleListServiceInterface::class);
        $moduleListServiceSpy->method('getModuleList')
            ->with($componentFilters)
            ->willReturn([$moduleStub]);

        $sut = new ModuleListController($moduleListServiceSpy);
        $resultModuleList = $sut->modules(null);

        $this->assertSame($resultModuleList, [$moduleStub]);
    }
}
