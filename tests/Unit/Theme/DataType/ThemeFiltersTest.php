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
        bool $expectedResult,
        bool $enableFilters,
    ): void {
        $stringFilterMock = $this->createMock(StringFilter::class);
        $stringFilterMock->method('matches')->willReturn($expectedResult);

        $themeMock = $this->createMock(ThemeDataType::class);
        $themeMock->method('getTitle')->willReturn($expectedThemeTitle);

        $themeFilters = ($enableFilters) ? new ThemeFilters(titleFilter: $stringFilterMock) : new ThemeFilters();
        $this->assertEquals($expectedResult, $themeFilters->filterThemeByTitle($themeMock));
    }

    public static function themeByTitleDataProvider(): \Generator
    {
        yield "filter theme by titles matches" => [
            'expectedThemeTitle' => 'test theme 1',
            'expectedResult' => true,
            'enableFilters' => true
        ];

        yield "filter theme by titles do not matches" => [
            'expectedThemeTitle' => 'random theme title',
            'expectedResult' => false,
            'enableFilters' => true
        ];

        yield "filter theme by title no filters" => [
            'expectedThemeTitle' => 'test theme 1',
            'expectedResult' => true,
            'enableFilters' => false,
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

        $this->assertSame($expectedResult, $themeFilterList->filterThemeByStatus($mockThemeDataType));
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
