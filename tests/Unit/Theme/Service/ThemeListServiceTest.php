<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService
 */
class ThemeListServiceTest extends TestCase
{
    public function testGetThemeListWithFilters(): void
    {
        $themeDataType1 = $this->createStub(ThemeDataTypeInterface::class);
        $themeDataType2 = $this->createStub(ThemeDataTypeInterface::class);
        $themes = [$themeDataType1, $themeDataType2];
        $filteredThemeList = [$themeDataType1];

        $themeListInfrastructureMock = $this->createMock(ThemeListInfrastructureInterface::class);
        $themeListInfrastructureMock->method('getThemes')->willReturn($themes);

        $componentFiltersStub = $this->createStub(ComponentFiltersInterface::class);

        $componentFilterServiceMock = $this->createMock(ComponentFilterServiceInterface::class);
        $componentFilterServiceMock->method('filterComponents')
            ->with($themes, $componentFiltersStub)
            ->willReturn($filteredThemeList);

        $themeListService = new ThemeListService(
            themeListInfrastructure: $themeListInfrastructureMock,
            componentFilterService:  $componentFilterServiceMock,
        );
        $actualThemes = $themeListService->getThemeList($componentFiltersStub);
        $this->assertSame($filteredThemeList, $actualThemes);
    }
}
