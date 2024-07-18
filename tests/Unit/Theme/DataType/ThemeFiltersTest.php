<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilters;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilters
 */
class ThemeFiltersTest extends TestCase
{
    /** @dataProvider themeByTitleDataProvider */
    public function testFilterThemeByTitle(
        string $expectedThemeTitle,
        string $actualThemeTitle,
        bool $expectedResult
    ): void {
        $mockThemeDataType = $this->createMock(ThemeDataType::class);
        $mockThemeDataType->method('getTitle')->willReturn($actualThemeTitle);

        $mockStringFilter = $this->createMock(StringFilter::class);
        $mockStringFilter->method('contains')->willReturn($expectedThemeTitle);
        $themeFilterList = new ThemeFilters(titleFilter: $mockStringFilter);

        $this->assertEquals($expectedResult, $themeFilterList->filterThemeByTitle($mockThemeDataType));
    }

    public static function themeByTitleDataProvider(): \Generator
    {
        yield "filter theme by providing same theme title" => [
            'expectedThemeTitle' => 'test theme 1',
            'actualThemeTitle' => 'test theme 1',
            'expectedResult' => true
        ];

        yield "filter theme by providing different theme title" => [
            'expectedThemeTitle' => 'test theme 1',
            'actualThemeTitle' => 'test theme 2',
            'expectedResult' => false
        ];
    }

    /** @dataProvider themeByStatusDataProvider */
    public function testFilterThemeByStatus(
        bool $expectedThemeStatus,
        bool $actualThemeStatus,
        bool $expectedResult
    ): void {
        $mockBoolFilter = $this->createMock(BoolFilter::class);
        $mockBoolFilter->method('equals')->willReturn($expectedThemeStatus);
        $themeFilterList = new ThemeFilters(activeFilter: $mockBoolFilter);

        $mockThemeDataType = $this->createMock(ThemeDataType::class);
        $mockThemeDataType->method('isActive')->willReturn($actualThemeStatus);

        $this->assertEquals($expectedResult, $themeFilterList->filterThemeByStatus($mockThemeDataType));
    }

    public static function themeByStatusDataProvider(): \Generator
    {
        yield "filter theme by providing same theme status" => [
            'expectedThemeStatus' => true,
            'actualThemeStatus' => true,
            'expectedResult' => true
        ];

        yield "filter theme by providing different theme status" => [
            'expectedThemeStatus' => true,
            'actualThemeStatus' => false,
            'expectedResult' => false
        ];
    }

    public function testCreateThemeFilterList(): void
    {
        $stringFilter = $this->createMock(StringFilter::class);
        $boolFilter = $this->createMock(BoolFilter::class);

        $themeFilterListSpy = ThemeFilters::createThemeFilters($stringFilter, $boolFilter);
        $this->assertInstanceOf(ThemeFilters::class, $themeFilterListSpy);
    }
}
