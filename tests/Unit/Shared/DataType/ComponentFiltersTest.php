<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ActiveFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\TitleFilter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFilters
 */
class ComponentFiltersTest extends TestCase
{
    /** @dataProvider filtersMatchesDataProvider */
    public function testFilterComponent(bool $titleFilterResult, bool $activeFilterResult, bool $result): void
    {
        $component = $this->createStub(ComponentDataTypeInterface::class);
        $titleFilterMock = $this->createMock(TitleFilter::class);
        $titleFilterMock->expects($this->once())->method('componentMatches')
            ->with($component)
            ->willReturn($titleFilterResult);
        $activeFilterMock = $this->createMock(ActiveFilter::class);
        $activeFilterMock->expects(($titleFilterResult ? $this->once() : $this->never()))->method('componentMatches')
            ->with($component)
            ->willReturn($activeFilterResult);

        $componentFilters = new ComponentFilters(titleFilter: $titleFilterMock, activeFilter: $activeFilterMock);
        $this->assertSame($result, $componentFilters->filterComponent($component));
    }

    public function testFilterComponentWithOneFilter(): void
    {
        $isMatching = (bool)random_int(0, 1);
        $component = $this->createStub(ComponentDataTypeInterface::class);
        $activeFilterMock = $this->createMock(ActiveFilter::class);
        $activeFilterMock->expects($this->once())->method('componentMatches')->with($component)->willReturn(
            $isMatching
        );

        $componentFilters = new ComponentFilters(titleFilter: null, activeFilter: $activeFilterMock);
        $this->assertSame($isMatching, $componentFilters->filterComponent($component));
    }

    public static function filtersMatchesDataProvider(): \Generator
    {
        yield "both filters matches" => [
            'titleFilterResult' => true,
            'activeFilterResult' => true,
            'result' => true
        ];

        yield "only title filter matches" => [
            'titleFilterResult' => true,
            'activeFilterResult' => false,
            'result' => false
        ];

        yield "only active filter matches" => [
            'titleFilterResult' => false,
            'activeFilterResult' => true,
            'result' => false
        ];

        yield "both filters are not matching" => [
            'titleFilterResult' => false,
            'activeFilterResult' => false,
            'result' => false
        ];
    }

    public function testComponentFiltersWithoutFilter(): void
    {
        $component = $this->createStub(ComponentDataTypeInterface::class);
        $componentFilters = new ComponentFilters();

        $this->assertTrue($componentFilters->filterComponent($component));
    }

    public function testCreateModuleFilterList(): void
    {
        $titleFilter = $this->createStub(TitleFilter::class);
        $activeFilter = $this->createStub(ActiveFilter::class);

        $expectedComponentFilters = new ComponentFilters(titleFilter: $titleFilter, activeFilter: $activeFilter);

        $componentFilters = ComponentFilters::createComponentFilters($titleFilter, $activeFilter);
        $this->assertEquals($expectedComponentFilters, $componentFilters);
    }

    public function testCreateModuleFilterListWithNull(): void
    {
        $expectedComponentFilters = new ComponentFilters();
        $componentFilters = ComponentFilters::createComponentFilters();
        $this->assertEquals($expectedComponentFilters, $componentFilters);
    }
}
