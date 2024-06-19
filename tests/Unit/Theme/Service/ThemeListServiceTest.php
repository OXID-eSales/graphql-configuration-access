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
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListService
 */
class ThemeListServiceTest extends TestCase
{
    private const THEME_TITLE = 'Test Theme 1';
    private const THEME_STATUS = true;

    public function testGetThemeListWithFilters(): void
    {
        $theme1 = new ThemeDataType('Test Theme 1', 'theme1', '1.0', 'Description 1', true);
        $theme2 = new ThemeDataType('Test Theme 2', 'theme2', '2.1', 'Description 2', false);

        $themeListRepositoryMock = $this->createMock(ThemeListRepositoryInterface::class);
        $themeListRepositoryMock->method('getThemes')
            ->willReturn([$theme1, $theme2]);

        $themeFilterServiceMock = $this->createMock(ThemeFilterServiceInterface::class);
        $themeFilterServiceMock->method('filterThemes')
            ->willReturn([$theme1]);

        $filtersList = new ThemeFilters(
            titleFilter: new StringFilter(contains: self::THEME_TITLE),
            activeFilter: new BoolFilter(equals: self::THEME_STATUS)
        );
        $themeListService = new ThemeListService(
            themeListRepository: $themeListRepositoryMock,
            themeFilterService:  $themeFilterServiceMock
        );
        $result = $themeListService->getThemeList($filtersList);

        $this->assertCount(1, $result);
        $this->assertSame('Test Theme 1', $result[0]->getTitle());
        $this->assertSame(true, $result[0]->isActive());
        $this->assertSame('1.0', $result[0]->getVersion());
    }
}
