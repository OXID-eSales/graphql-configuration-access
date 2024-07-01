<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters
 */
class ModuleFiltersTest extends TestCase
{
    /** @dataProvider moduleByTitleDataProvider */
    public function testFilterModuleByTitle(
        string $expectedTitle,
        bool $expectedResult,
        bool $enableFilters,
    ): void {
        $stringFilterMock = $this->createMock(StringFilter::class);
        $stringFilterMock->method('matches')->willReturn($expectedResult);

        $moduleMock = $this->createMock(ModuleDataType::class);
        $moduleMock->method('getTitle')->willReturn($expectedTitle);

        $moduleFilters = ($enableFilters) ? new ModuleFilters(titleFilter: $stringFilterMock) : new ModuleFilters();
        $this->assertEquals($expectedResult, $moduleFilters->filterModuleByTitle($moduleMock));
    }

    public static function moduleByTitleDataProvider(): \Generator
    {
        yield "filter module by titles matches" => [
            'expectedTitle' => 'test module 1',
            'expectedResult' => true,
            'enableFilters' => true
        ];

        yield "filter module by titles do not matches" => [
            'expectedTitle' => 'random module title',
            'expectedResult' => false,
            'enableFilters' => true
        ];

        yield "filter module by title no filters" => [
            'expectedTitle' => 'test module 1',
            'expectedResult' => true,
            'enableFilters' => false,
        ];
    }

    /** @dataProvider moduleByStatusDataProvider */
    public function testFilterModuleByStatus(
        bool $expectedStatus,
        bool $actualStatus,
        bool $expectedResult
    ): void {
        $mockBoolFilter = $this->createMock(BoolFilter::class);
        $mockBoolFilter->method('equals')->willReturn($expectedStatus);
        $moduleFilterList = new ModuleFilters(activeFilter: $mockBoolFilter);

        $mockModuleDataType = $this->createMock(ModuleDataType::class);
        $mockModuleDataType->method('isActive')->willReturn($actualStatus);

        $this->assertSame($expectedResult, $moduleFilterList->filterModuleByStatus($mockModuleDataType));
    }

    public static function moduleByStatusDataProvider(): \Generator
    {
        yield "filter module by providing same module status" => [
            'expectedStatus' => true,
            'actualStatus' => true,
            'expectedResult' => true
        ];

        yield "filter module by providing different module status" => [
            'expectedStatus' => true,
            'actualStatus' => false,
            'expectedResult' => false
        ];
    }

    public function testCreateModuleFilterList(): void
    {
        $stringFilter = $this->createMock(StringFilter::class);
        $boolFilter = $this->createMock(BoolFilter::class);

        $moduleFilterListSpy = ModuleFilters::createModuleFilters($stringFilter, $boolFilter);
        $this->assertInstanceOf(ModuleFilters::class, $moduleFilterListSpy);
    }
}
