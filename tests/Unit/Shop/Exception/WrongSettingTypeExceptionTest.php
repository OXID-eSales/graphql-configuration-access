<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shop\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception\NoSettingsFoundForShopException;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception\WrongSettingTypeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception\WrongSettingTypeException
 */
class WrongSettingTypeExceptionTest extends TestCase
{
    public function testExceptionMessage(): void
    {
        $sut = new WrongSettingTypeException();
        $this->assertSame('Wrong setting type', $sut->getMessage());
    }
}
