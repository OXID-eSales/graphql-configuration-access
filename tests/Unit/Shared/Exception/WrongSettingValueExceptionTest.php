<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\WrongSettingValueException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\WrongSettingValueException
 */
class WrongSettingValueExceptionTest extends TestCase
{
    public function testExceptionMessage()
    {
        $sut = new WrongSettingValueException();
        $this->assertSame('Wrong setting value', $sut->getMessage());
    }
}
