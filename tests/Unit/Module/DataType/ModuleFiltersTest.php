<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters
 */
class ModuleFiltersTest extends TestCase
{
    /** @dataProvider moduleByTitleDataProvider */
    public function testFilterModuleByTitle(
        bool $expectedResult,
    ): void {
        $title = uniqid();
        $stringFilterMock = $this->createMock(StringFilter::class);
        $stringFilterMock->expects($this->once())->method('matches')->with($title)->willReturn($expectedResult);

        $moduleMock = $this->createMock(ModuleDataTypeInterface::class);
        $moduleMock->expects($this->once())->method('getTitle')->willReturn($title);

        $themeFilters = new ModuleFilters(titleFilter: $stringFilterMock);
        $this->assertEquals($expectedResult, $themeFilters->filterModuleByTitle($moduleMock));
    }

    public static function moduleByTitleDataProvider(): \Generator
    {
        yield "filter module by title matches" => [
            'expectedResult' => true,
        ];

        yield "filter module by title do not matches" => [
            'expectedResult' => false,
        ];
    }

    public function testModuleFiltersWithoutFilter(): void
    {
        $themeMock = $this->createStub(ModuleDataTypeInterface::class);

        $themeFilters = new ModuleFilters();
        $this->assertTrue($themeFilters->filterModuleByTitle($themeMock));
        $this->assertTrue($themeFilters->filterModuleByStatus($themeMock));
    }

    /** @dataProvider moduleByStatusDataProvider */
    public function testFilterModuleByStatus(
        bool $filterStatus,
        bool $actualStatus,
        bool $expectedResult
    ): void {
        $mockBoolFilter = $this->createMock(BoolFilter::class);
        $mockBoolFilter->expects($this->exactly(2))->method('equals')->willReturn($filterStatus);
        $moduleFilterList = new ModuleFilters(activeFilter: $mockBoolFilter);

        $mockModuleDataType = $this->createMock(ModuleDataTypeInterface::class);
        $mockModuleDataType->expects($this->once())->method('isActive')->willReturn($actualStatus);

        $this->assertSame($expectedResult, $moduleFilterList->filterModuleByStatus($mockModuleDataType));
    }

    public static function moduleByStatusDataProvider(): \Generator
    {
        yield "filter module by true with same module status" => [
            'filterStatus' => true,
            'actualStatus' => true,
            'expectedResult' => true
        ];

        yield "filter module by false with same module status" => [
            'filterStatus' => false,
            'actualStatus' => false,
            'expectedResult' => true
        ];

        yield "filter module by true with different module status" => [
            'filterStatus' => true,
            'actualStatus' => false,
            'expectedResult' => false
        ];

        yield "filter module by false with different theme status" => [
            'filterStatus' => false,
            'actualStatus' => true,
            'expectedResult' => false
        ];
    }

    public function testCreateModuleFilterList(): void
    {
        $stringFilter = $this->createMock(StringFilter::class);
        $boolFilter = $this->createStub(BoolFilter::class);

        $expectedModuleFilters = new ModuleFilters(titleFilter: $stringFilter, activeFilter: $boolFilter);

        $moduleFilters = ModuleFilters::createModuleFilters($stringFilter, $boolFilter);
        $this->assertEquals($expectedModuleFilters, $moduleFilters);
    }

    public function testCreateModuleFilterListWithNull(): void
    {
        $expectedThemeFilters = new ModuleFilters();
        $themeFilters = ModuleFilters::createModuleFilters(null, null);
        $this->assertEquals($expectedThemeFilters, $themeFilters);
    }
}
