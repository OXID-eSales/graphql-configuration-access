<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\TitleFilter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\TitleFilter
 */
class TitleFilterTest extends TestCase
{
    public function testTitleFilterExtendsStringFilter(): void
    {
        $filter = new TitleFilter(equals: uniqid());
        $this->assertInstanceOf(StringFilter::class, $filter);
    }

    public function testComponentMatches(): void
    {
        $component = $this->createMock(ComponentDataTypeInterface::class);
        $component->method('getTitle')->willReturn($title = uniqid());

        $titleFilterSpy = $this->getMockBuilder(TitleFilter::class)
            ->setConstructorArgs([uniqid()])
            ->onlyMethods(['matches'])
            ->getMock();
        $titleFilterSpy->method('matches')->with($title)->willReturn($expectedMatch = (bool) rand(0, 1));
        $this->assertSame($expectedMatch, $titleFilterSpy->componentMatches($component));
    }
}
