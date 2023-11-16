<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting
 */
class BooleanSettingTest extends TestCase
{
    /** @dataProvider booleanSettingDataProvider */
    public function testBooleanSetting(ID $name, bool $value): void
    {
        $sut = new BooleanSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public function booleanSettingDataProvider(): \Generator
    {
        yield [new ID('boolean positive setting'), true];
        yield [new ID('boolean negative setting'), false];
    }
}
