<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\ComponentFilterService;
 */
class ComponentFilterServiceTest extends TestCase
{
    /** @dataProvider componentFilterResultProvider */
    public function testFilterThemes(
        array $componentList,
        array $filterResults,
        array $expectedComponentListResult
    ): void {
        $componentFiltersMock = $this->createMock(ComponentFiltersInterface::class);
        $componentFiltersMock->method('filterComponent')
            ->willReturnCallback(function (ComponentDataTypeInterface $component) use (&$filterResults) {
                return array_shift($filterResults);
            });

        $themeFilterService = new ComponentFilterService();
        $componentListResult = $themeFilterService->filterComponents($componentList, $componentFiltersMock);
        $this->assertSame($expectedComponentListResult, array_values($componentListResult));
    }

    public static function componentFilterResultProvider(): \Generator
    {
        $theme1 = self::createStub(ComponentDataTypeInterface::class);
        $theme2 = self::createStub(ComponentDataTypeInterface::class);

        yield "filter with filter results are both false" => [
            'componentList' => [$theme1, $theme2],
            'filterResults' => [false, false],
            'expectedComponentListResult' => []
        ];

        yield "filter with only first filter result is true" => [
            'componentList' => [$theme1, $theme2],
            'filterResults' => [true, false],
            'expectedComponentListResult' => [$theme1]
        ];

        yield "filter with only second filter result is true" => [
            'componentList' => [$theme1, $theme2],
            'filterResults' => [false, true],
            'expectedComponentListResult' => [$theme2]
        ];

        yield "filter with both filter results are true" => [
            'componentList' => [$theme1, $theme2],
            'filterResults' => [true, true],
            'expectedComponentListResult' => [$theme1, $theme2]
        ];
    }
}
