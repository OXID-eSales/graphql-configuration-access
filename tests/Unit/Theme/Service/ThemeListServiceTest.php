<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService;
use PHPUnit\Framework\TestCase;
use OxidEsales\Eshop\Core\Theme;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService
 */
class ThemeListServiceTest extends TestCase
{
    public function testGetThemeListWithFilters(): void
    {
        $theme1 = $this->createStub(Theme::class);
        $theme2 = $this->createStub(Theme::class);
        $themes = [$theme1, $theme2];
        $themeDataType1 = $this->createStub(ThemeDataTypeInterface::class);
        $themeDataType2 = $this->createStub(ThemeDataTypeInterface::class);
        $themeList = [$themeDataType1, $themeDataType2];
        $filteredThemeList = [$themeDataType1];

        $themeListInfrastructureMock = $this->createMock(ThemeListInfrastructureInterface::class);
        $themeListInfrastructureMock->method('getThemes')->willReturn($themes);

        $themeDataTypeFactoryMock = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $themeDataTypeFactoryMock
            ->expects($this->exactly(2))
            ->method('createFromCoreTheme')
            ->willReturnMap([
                [$theme1, $themeDataType1],
                [$theme2, $themeDataType2]
            ]);

        $componentFiltersStub = $this->createStub(ComponentFiltersInterface::class);

        $componentFilterServiceMock = $this->createMock(ComponentFilterServiceInterface::class);
        $componentFilterServiceMock->method('filterComponents')
            ->with($themeList, $componentFiltersStub)
            ->willReturn($filteredThemeList);

        $themeListService = new ThemeListService(
            themeListInfrastructure: $themeListInfrastructureMock,
            componentFilterService:  $componentFilterServiceMock,
            themeDataTypeFactory:  $themeDataTypeFactoryMock
        );
        $actualThemes = $themeListService->getThemeList($componentFiltersStub);
        $this->assertSame($filteredThemeList, $actualThemes);
    }
}
