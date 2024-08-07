<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFilters;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentFilters
 */
class ComponentFiltersTest extends TestCase
{
    /** @dataProvider componentByTitleDataProvider */
    public function testFilterComponentByTitle(
        bool $expectedResult,
    ): void {

        $title = uniqid();
        $stringFilterMock = $this->createMock(StringFilter::class);
        $stringFilterMock->method('matches')->with($title)->willReturn($expectedResult);

        $componentFilters = new ComponentFilters(titleFilter: $stringFilterMock);
        $filterComponentByTitleMethod = $this->getComponentFiltersMethod('filterComponentByTitle');

        $this->assertEquals($expectedResult, $filterComponentByTitleMethod->invoke($componentFilters, $title));
    }

    public static function componentByTitleDataProvider(): \Generator
    {
        yield "filter component by title matches" => [
            'expectedResult' => true,
        ];

        yield "filter component by title do not matches" => [
            'expectedResult' => false,
        ];
    }

    public function testComponentFiltersWithoutFilter(): void
    {
        $themeFilters = new ComponentFilters();
        $filterComponentByTitleMethod = $this->getComponentFiltersMethod('filterComponentByTitle');
        $filterComponentByStatusMethod = $this->getComponentFiltersMethod('filterComponentByStatus');

        $this->assertTrue($filterComponentByTitleMethod->invoke($themeFilters, uniqid()));
        $this->assertTrue($filterComponentByStatusMethod->invoke($themeFilters, (bool)random_int(0, 1)));
    }

    /** @dataProvider componentByStatusDataProvider */
    public function testFilterComponentByStatus(
        bool $filterStatus,
        bool $actualStatus,
        bool $expectedResult
    ): void {
        $boolFilterStub = $this->createConfiguredStub(BoolFilter::class, [
            'equals' => $filterStatus
        ]);

        $componentFilters = new ComponentFilters(activeFilter: $boolFilterStub);
        $filterComponentByStatusMethod = $this->getComponentFiltersMethod('filterComponentByStatus');
        $this->assertEquals($expectedResult, $filterComponentByStatusMethod->invoke($componentFilters, $actualStatus));
    }

    public static function componentByStatusDataProvider(): \Generator
    {
        yield "filter component by true with same module status" => [
            'filterStatus' => true,
            'actualStatus' => true,
            'expectedResult' => true
        ];

        yield "filter component by false with same module status" => [
            'filterStatus' => false,
            'actualStatus' => false,
            'expectedResult' => true
        ];

        yield "filter component by true with different module status" => [
            'filterStatus' => true,
            'actualStatus' => false,
            'expectedResult' => false
        ];

        yield "filter component by false with different theme status" => [
            'filterStatus' => false,
            'actualStatus' => true,
            'expectedResult' => false
        ];
    }

    public function testCreateModuleFilterList(): void
    {
        $stringFilter = $this->createStub(StringFilter::class);
        $boolFilter = $this->createStub(BoolFilter::class);

        $expectedComponentFilters = new ComponentFilters(titleFilter: $stringFilter, activeFilter: $boolFilter);

        $componentFilters = ComponentFilters::createComponentFilters($stringFilter, $boolFilter);
        $this->assertEquals($expectedComponentFilters, $componentFilters);
    }

    public function testCreateModuleFilterListWithNull(): void
    {
        $expectedComponentFilters = new ComponentFilters();
        $componentFilters = ComponentFilters::createComponentFilters(null, null);
        $this->assertEquals($expectedComponentFilters, $componentFilters);
    }

    private static function getComponentFiltersMethod($name)
    {
        $class = new ReflectionClass(ComponentFilters::class);
        $method = $class->getMethod($name);
        return $method;
    }
}
