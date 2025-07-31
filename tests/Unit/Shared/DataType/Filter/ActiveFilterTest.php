<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ActiveFilter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ActiveFilter
 */
class ActiveFilterTest extends TestCase
{
    public function testActiveFilterExtendsBoolFilter(): void
    {
        $filter = new ActiveFilter();
        $this->assertInstanceOf(BoolFilter::class, $filter);
    }

    public function testComponentMatches(): void
    {
        $component = $this->createMock(ComponentDataTypeInterface::class);
        $component->method('isActive')->willReturn($active = (bool) rand(0, 1));


        $activeFilterSpy = $this->getMockBuilder(ActiveFilter::class)->onlyMethods(['equals'])->getMock();
        $activeFilterSpy->method('equals')->willReturn($active);
        $this->assertTrue($activeFilterSpy->componentMatches($component));
    }

    public function testComponentNotMatches(): void
    {
        $component = $this->createMock(ComponentDataTypeInterface::class);
        $component->method('isActive')->willReturn($active = (bool) rand(0, 1));


        $activeFilterSpy = $this->getMockBuilder(ActiveFilter::class)->onlyMethods(['equals'])->getMock();
        $activeFilterSpy->method('equals')->willReturn(!$active);
        $this->assertFalse($activeFilterSpy->componentMatches($component));
    }
}
