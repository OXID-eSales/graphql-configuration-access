<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeListController;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeListController
 */
class ThemeListControllerTest extends TestCase
{
    public function testThemesListWithFilter(): void
    {
        $theme = $this->createStub(ThemeDataTypeInterface::class);
        $themeFilters = $this->createStub(ComponentFilters::class);

        $themeListServiceMock = $this->createMock(ThemeListServiceInterface::class);
        $themeListServiceMock->expects($this->once())
            ->method('getThemeList')
            ->with($themeFilters)
            ->willReturn([$theme]);

        $themeListController = new ThemeListController($themeListServiceMock);
        $resultedThemeList = $themeListController->themesList($themeFilters);

        $this->assertSame([$theme], $resultedThemeList);
    }

    public function testThemesListWithoutFilter(): void
    {
        $theme = $this->createStub(ThemeDataTypeInterface::class);
        $themeFilters = new ComponentFilters();

        $themeListServiceMock = $this->createMock(ThemeListServiceInterface::class);
        $themeListServiceMock->expects($this->once())
            ->method('getThemeList')
            ->with($themeFilters)
            ->willReturn([$theme]);

        $themeListController = new ThemeListController($themeListServiceMock);
        $resultedThemeList = $themeListController->themesList(null);

        $this->assertSame($resultedThemeList, [$theme]);
    }
}
