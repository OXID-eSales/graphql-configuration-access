<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFilters;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFilters
 */
class ComponentFiltersTest extends TestCase
{
    /** @dataProvider filtersMatchesDataProvider */
    public function testFilterComponent(bool $titleFilterResult, bool $activeFilterResult, bool $result): void
    {
        $component = $this->createConfiguredStub(ComponentDataTypeInterface::class, [
            'getTitle' => $filteredTitle = uniqid(),
            'isActive' => $filteredIsActive = (bool)random_int(0, 1),
        ]);
        $titleFilterMock = $this->createMock(StringFilter::class);
        $titleFilterMock->expects($this->once())->method('matches')
            ->with($filteredTitle)
            ->willReturn($titleFilterResult);
        $activeFilterMock = $this->createMock(BoolFilter::class);
        $activeFilterMock->expects(($titleFilterResult ? $this->once() : $this->never()))->method('matches')
            ->with($filteredIsActive)
            ->willReturn($activeFilterResult);

        $componentFilters = new ComponentFilters(titleFilter: $titleFilterMock, activeFilter: $activeFilterMock);
        $this->assertSame($result, $componentFilters->filterComponent($component));
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

    public function testFilterComponentWithOneFilter(): void
    {
        $isMatching = (bool)random_int(0, 1);
        $component = $this->createConfiguredStub(
            ComponentDataTypeInterface::class,
            ['isActive' => $isActive = (bool)random_int(0, 1)]
        );
        $activeFilterMock = $this->createMock(BoolFilter::class);
        $activeFilterMock->expects($this->once())->method('matches')->with($isActive)->willReturn(
            $isMatching
        );

        $componentFilters = new ComponentFilters(titleFilter: null, activeFilter: $activeFilterMock);
        $this->assertSame($isMatching, $componentFilters->filterComponent($component));
    }

    public function testComponentFiltersWithoutFilter(): void
    {
        $component = $this->createStub(ComponentDataTypeInterface::class);
        $componentFilters = new ComponentFilters();

        $this->assertTrue($componentFilters->filterComponent($component));
    }

    public function testCreateModuleFilterList(): void
    {
        $titleFilter = $this->createStub(StringFilter::class);
        $activeFilter = $this->createStub(BoolFilter::class);

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
