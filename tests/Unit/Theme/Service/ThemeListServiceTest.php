<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService
 */
class ThemeListServiceTest extends TestCase
{
    public function testGetThemeListWithFilters(): void
    {
        $theme1 = new ThemeDataType(uniqid(), uniqid(), uniqid(), uniqid(), true);
        $theme2 = new ThemeDataType(uniqid(), uniqid(), uniqid(), uniqid(), false);
        $themeList = [$theme1, $theme2];
        $filteredThemeList = [$theme1];

        $themeListInfrastructureMock = $this->createMock(ThemeListInfrastructureInterface::class);
        $themeListInfrastructureMock->expects($this->once())->method('getThemes')
            ->willReturn($themeList);

        $filtersList = new ThemeFilters(
            titleFilter: new StringFilter(contains: uniqid()),
            activeFilter: new BoolFilter(equals: (bool)rand(0, 1))
        );

        $themeFilterServiceMock = $this->createMock(ThemeFilterServiceInterface::class);
        $themeFilterServiceMock->expects($this->once())->method('filterThemes')
            ->with($themeList, $filtersList)
            ->willReturn($filteredThemeList);

        $themeListService = new ThemeListService(
            themeListInfrastructure: $themeListInfrastructureMock,
            themeFilterService:  $themeFilterServiceMock
        );
        $actualThemes = $themeListService->getThemeList($filtersList);
        $this->assertSame($filteredThemeList, $actualThemes);
    }
}
