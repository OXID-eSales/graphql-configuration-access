<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting
 */
class FloatSettingTest extends TestCase
{
    /** @dataProvider floatSettingDataProvider */
    public function testFloatSetting(string $name, float $value): void
    {
        $sut = new FloatSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public function floatSettingDataProvider(): \Generator
    {
        yield "random float" => [uniqid(), rand(1, 100) / 10];
        yield "random integer" => [uniqid(), rand(1, 100)];
    }
}
