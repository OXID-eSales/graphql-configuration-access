<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleListController;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters;
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
        $filtersStub = $this->createStub(ModuleFilters::class);
        $moduleStub1 = $this->createStub(ModuleDataType::class);
        $moduleStub2 = $this->createStub(ModuleDataType::class);
        $filteredModules = [$moduleStub1, $moduleStub2];

        $moduleListServiceMock = $this->createMock(ModuleListServiceInterface::class);
        $moduleListServiceMock->expects($this->once())
            ->method('getModuleList')
            ->with($filtersStub)
            ->willReturn($filteredModules);

        $sut = new ModuleListController($moduleListServiceMock);
        $actualModules = $sut->modulesList($filtersStub);

        $this->assertSame($filteredModules, $actualModules);
    }
}
