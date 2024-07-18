<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Controller;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeListController;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeListController
 */
class ThemeListControllerTest extends TestCase
{
    public function testThemesListWithFilter(): void
    {
        $theme = new ThemeDataType(uniqid(), uniqid(), uniqid(), uniqid(), true);
        $themeFilters = new ThemeFilters(
            titleFilter: new StringFilter(contains: $theme->getTitle()),
            activeFilter: new BoolFilter(equals: true)
        );

        $themeListServiceMock = $this->createMock(ThemeListServiceInterface::class);
        $themeListServiceMock
            ->method('getThemeList')
            ->with($themeFilters)
            ->willReturn([$theme]);

        $themeListController = new ThemeListController($themeListServiceMock);
        $resultedThemeList = $themeListController->themesList($themeFilters);

        $this->assertSame($resultedThemeList, [$theme]);
    }

    public function testThemesListWithoutFilter(): void
    {
        $theme = new ThemeDataType(uniqid(), uniqid(), uniqid(), uniqid(), true);
        $themeFilters = new ThemeFilters();

        $themeListServiceMock = $this->createMock(ThemeListServiceInterface::class);
        $themeListServiceMock
            ->method('getThemeList')
            ->with($themeFilters)
            ->willReturn([$theme]);

        $themeListController = new ThemeListController($themeListServiceMock);
        $resultedThemeList = $themeListController->themesList($themeFilters);

        $this->assertSame($resultedThemeList, [$theme]);
    }
}
