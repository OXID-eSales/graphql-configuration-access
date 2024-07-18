<?php

/**
* Copyright © OXID eSales AG. All rights reserved.
* See LICENSE file for license details.
*/

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeNotFound;
use PHPUnit\Framework\TestCase;

/**
* @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeNotFound
*/
class ThemeNotFoundTest extends TestCase
{
    public function testThemeNotFoundException()
    {
        $exception = new ThemeNotFound();

        $this->assertInstanceOf(ThemeNotFound::class, $exception);
        $this->assertSame('Theme was not found.', $exception->getMessage());
    }
}
