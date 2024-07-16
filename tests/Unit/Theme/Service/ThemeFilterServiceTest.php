<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterService
 */
class ThemeFilterServiceTest extends TestCase
{
    /** @dataProvider themeFilterResultProvider */
    public function testFilterThemes(
        array $themeList,
        array $titleFilterResults,
        array $statusFilterResults,
        array $expectedThemeListResult
    ): void {
        $themeFiltersMock = $this->createMock(ThemeFiltersInterface::class);
        $themeFiltersMock->expects($this->exactly(count($titleFilterResults)))->method('filterThemeByTitle')
            ->willReturnCallback(function (ThemeDataType $theme) use (&$titleFilterResults) {
                return array_shift($titleFilterResults);
            });
        $themeFiltersMock->expects($this->exactly(count($statusFilterResults)))->method('filterThemeByStatus')
            ->willReturnCallback(function (ThemeDataType $theme) use (&$statusFilterResults) {
                return array_shift($statusFilterResults);
            });

        $themeFilterService = new ThemeFilterService();
        $themeListResult = $themeFilterService->filterThemes($themeList, $themeFiltersMock);
        $this->assertCount(count($expectedThemeListResult), $themeListResult);
        foreach ($expectedThemeListResult as $theme) {
            $this->assertContains($theme, $themeListResult);
        }
    }

    public static function themeFilterResultProvider(): \Generator
    {
        $theme1 = new ThemeDataType('theme1', uniqid(), uniqid(), uniqid(), true);
        $theme2 = new ThemeDataType('theme2', uniqid(), uniqid(), uniqid(), false);

        yield "filter with mixed results" => [
            'themeList' => [$theme1, $theme2],
            'titleFilterResults' => [false, true],
            'statusFilterResults' => [false],
            'expectedThemeListResult' => []
        ];

        yield "filter with all false" => [
            'themeList' => [$theme1, $theme2],
            'titleFilterResults' => [false, false],
            'statusFilterResults' => [],
            'expectedThemeListResult' => []
        ];

        yield "filter with first true" => [
            'themeList' => [$theme1, $theme2],
            'titleFilterResults' => [true, false],
            'statusFilterResults' => [true],
            'expectedThemeListResult' => [$theme1]
        ];

        yield "filter with seconde true" => [
            'themeList' => [$theme1, $theme2],
            'titleFilterResults' => [false, true],
            'statusFilterResults' => [true],
            'expectedThemeListResult' => [$theme2]
        ];

        yield "filter with all true" => [
            'themeList' => [$theme1, $theme2],
            'titleFilterResults' => [true, true],
            'statusFilterResults' => [true, true],
            'expectedThemeListResult' => [$theme1, $theme2]
        ];
    }
}
