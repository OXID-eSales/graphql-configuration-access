<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting
 */
class IntegerSettingTest extends TestCase
{
    /** @dataProvider integerSettingDataProvider */
    public function testIntegerSetting(ID $name, int $value): void
    {
        $sut = new IntegerSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public function integerSettingDataProvider(): \Generator
    {
        yield "random integer" => [new ID(uniqid()), rand(1, 100)];
    }
}
