<?php

/**
* Copyright © OXID eSales AG. All rights reserved.
* See LICENSE file for license details.
*/

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;
use PHPUnit\Framework\TestCase;

/**
* @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound
*/
class ThemesNotFoundTest extends TestCase
{
    public function testThemeNotFoundException()
    {
        $exception = new ThemesNotFound();

        $this->assertInstanceOf(ThemesNotFound::class, $exception);
        $this->assertSame('Theme was not found.', $exception->getMessage());
    }
}
