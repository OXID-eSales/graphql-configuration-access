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
        bool $expectedResult,
    ): void {
        $title = uniqid();
        $stringFilterMock = $this->createMock(StringFilter::class);
        $stringFilterMock->expects($this->once())->method('matches')->with($title)->willReturn($expectedResult);

        $themeMock = $this->createMock(ThemeDataType::class);
        $themeMock->expects($this->once())->method('getTitle')->willReturn($title);

        $themeFilters = new ThemeFilters(titleFilter: $stringFilterMock);
        $this->assertEquals($expectedResult, $themeFilters->filterThemeByTitle($themeMock));
    }

    public static function themeByTitleDataProvider(): \Generator
    {
        yield "filter theme by title match" => [
            'expectedResult' => true,
        ];

        yield "filter theme by title do not match" => [
            'expectedResult' => false,
        ];
    }

    public function testThemeFiltersWithoutFilter(): void
    {
        $themeMock = $this->createStub(ThemeDataType::class);

        $themeFilters = new ThemeFilters();
        $this->assertTrue($themeFilters->filterThemeByTitle($themeMock));
        $this->assertTrue($themeFilters->filterThemeByStatus($themeMock));
    }

    /** @dataProvider themeByStatusDataProvider */
    public function testFilterThemeByStatus(
        bool $filterStatus,
        bool $actualThemeStatus,
        bool $expectedResult
    ): void {
        $mockBoolFilter = $this->createMock(BoolFilter::class);
        $mockBoolFilter->expects($this->exactly(2))->method('equals')->willReturn($filterStatus);
        $themeFilterList = new ThemeFilters(activeFilter: $mockBoolFilter);

        $mockThemeDataType = $this->createMock(ThemeDataType::class);
        $mockThemeDataType->expects($this->once())->method('isActive')->willReturn($actualThemeStatus);

        $this->assertSame($expectedResult, $themeFilterList->filterThemeByStatus($mockThemeDataType));
    }

    public static function themeByStatusDataProvider(): \Generator
    {
        yield "filter theme by true with same theme status" => [
            'filterStatus' => true,
            'actualThemeStatus' => true,
            'expectedResult' => true
        ];

        yield "filter theme by false with same theme status" => [
            'filterStatus' => false,
            'actualThemeStatus' => false,
            'expectedResult' => true
        ];

        yield "filter theme by true with different theme status" => [
            'filterStatus' => true,
            'actualThemeStatus' => false,
            'expectedResult' => false
        ];

        yield "filter theme by false with different theme status" => [
            'filterStatus' => false,
            'actualThemeStatus' => true,
            'expectedResult' => false
        ];
    }

    public function testCreateThemeFilterList(): void
    {
        $stringFilter = $this->createStub(StringFilter::class);
        $boolFilter = $this->createStub(BoolFilter::class);

        $expectedThemeFilters = new ThemeFilters(titleFilter: $stringFilter, activeFilter: $boolFilter);

        $themeFilters = ThemeFilters::createThemeFilters($stringFilter, $boolFilter);
        $this->assertEquals($expectedThemeFilters, $themeFilters);
    }

    public function testCreateThemeFilterListWithNull(): void
    {
        $expectedThemeFilters = new ThemeFilters();
        $themeFilters = ThemeFilters::createThemeFilters(null, null);
        $this->assertEquals($expectedThemeFilters, $themeFilters);
    }
}
