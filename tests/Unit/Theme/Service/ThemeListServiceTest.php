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

        $themeListInfrastructureMock = $this->createMock(ThemeListInfrastructureInterface::class);
        $themeListInfrastructureMock->method('getThemes')
            ->willReturn([$theme1,$theme2]);

        $themeFilterServiceMock = $this->createMock(ThemeFilterServiceInterface::class);
        $themeFilterServiceMock->method('filterThemes')
            ->willReturn([$theme1]);

        $filtersList = new ThemeFilters(
            titleFilter: new StringFilter(contains: $theme1->getTitle()),
            activeFilter: new BoolFilter(equals: $theme1->isActive())
        );
        $themeListService = new ThemeListService(
            themeListInfrastructure: $themeListInfrastructureMock,
            themeFilterService:  $themeFilterServiceMock
        );
        $actualThemes = $themeListService->getThemeList($filtersList);
        $actualTheme = $actualThemes[0];

        $this->assertCount(1, $actualThemes);
        $this->assertSame($theme1->getTitle(), $actualTheme->getTitle());
        $this->assertSame($theme1->getVersion(), $actualTheme->getVersion());
        $this->assertSame(true, $actualTheme->isActive());
    }
}
