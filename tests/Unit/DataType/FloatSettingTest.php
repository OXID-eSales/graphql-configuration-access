<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting
 */
class FloatSettingTest extends TestCase
{
    /** @dataProvider floatSettingDataProvider */
    public function testFloatSetting(ID $name, float $value): void
    {
        $sut = new FloatSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public function floatSettingDataProvider(): \Generator
    {
        yield "random float" => [new ID(uniqid()), rand(1, 100) / 10];
        yield "random integer" => [new ID(uniqid()), rand(1, 100)];
    }
}
