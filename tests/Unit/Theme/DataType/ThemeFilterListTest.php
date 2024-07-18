<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterList;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterList
 */
class ThemeFilterListTest extends TestCase
{
    public function testThemeFilterList(): void
    {
        $filter = new ThemeFilterList();
        $this->assertEquals(
            [
                'title' => null,
                'active' => null
            ],
            $filter->getFilters()
        );
    }
}
