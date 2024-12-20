<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListService;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListService
 */
class ModuleListServiceTest extends UnitTestCase
{
    public function testGetModuleListWithFilters(): void
    {
        $filtersStub = $this->createStub(ComponentFiltersInterface::class);
        $moduleStub1 = $this->createStub(ModuleDataTypeInterface::class);
        $moduleStub2 = $this->createStub(ModuleDataTypeInterface::class);
        $filteredModules = [$moduleStub1];

        $modulesConfigurations = [$moduleStub1, $moduleStub2];

        $moduleListInfrastructureMock = $this->createMock(ModuleListInfrastructureInterface::class);
        $moduleListInfrastructureMock->method('getModuleList')
            ->willReturn($modulesConfigurations);

        $componentFilterServiceMock = $this->createMock(ComponentFilterServiceInterface::class);
        $componentFilterServiceMock->method('filterComponents')
            ->with($modulesConfigurations, $filtersStub)
            ->willReturn($filteredModules);

        $sut = new ModuleListService(
            moduleListInfrastructure: $moduleListInfrastructureMock,
            componentFilterService: $componentFilterServiceMock,
        );

        $actualModules = $sut->getModuleList($filtersStub);
        $this->assertSame($filteredModules, $actualModules);
    }
}
