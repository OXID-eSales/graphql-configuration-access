<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

class SettingTest extends UnitTestCase
{
    public function testBooleanSetting(): void
    {
        $setting = $this->getNegativeBooleanSetting();

        $this->assertEquals(new ID('booleanSetting'), $setting->getName());
        $this->assertFalse($setting->getValue());
    }

    public function testFloatSetting(): void
    {
        $setting = $this->getFloatSetting();

        $this->assertEquals(new ID('floatSetting'), $setting->getName());
        $this->assertSame(1.23, $setting->getValue());
    }

    public function testIntegerSetting(): void
    {
        $setting = $this->getIntegerSetting();

        $this->assertEquals(new ID('integerSetting'), $setting->getName());
        $this->assertSame(123, $setting->getValue());
    }

    public function testStringSetting(): void
    {
        $setting = $this->getStringSetting();

        $this->assertEquals(new ID('stringSetting'), $setting->getName());
        $this->assertSame('default', $setting->getValue());
    }

    public function testStringSettingAsCollection(): void
    {
        $setting = $this->getCollectionSetting();

        $this->assertEquals(new ID('arraySetting'), $setting->getName());
        $this->assertSame(json_encode(['nice', 'values']), $setting->getValue());
    }
}
