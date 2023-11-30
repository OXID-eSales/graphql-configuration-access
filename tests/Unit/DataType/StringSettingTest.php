<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting
 */
class StringSettingTest extends TestCase
{
    /** @dataProvider stringSettingDataProvider */
    public function testStringSetting(ID $name, $value): void
    {
        $sut = new StringSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public function stringSettingDataProvider(): \Generator
    {
        yield "random strings" => [new ID(uniqid()), uniqid()];
    }
}
