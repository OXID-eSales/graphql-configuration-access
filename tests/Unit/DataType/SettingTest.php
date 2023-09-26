<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class SettingTest extends TestCase
{
    public function testBooleanSetting(): void
    {
        $setting = new BooleanSetting('coolBoolSetting', 'Awesome boolean', true);

        $this->assertSame('coolBoolSetting', $setting->getName());
        $this->assertSame('Awesome boolean', $setting->getDescription());
        $this->assertTrue($setting->getValue());
    }

    public function testFloatSetting(): void
    {
        $setting = new FloatSetting('coolFloatSetting', 'Awesome float', 1.23);

        $this->assertSame('coolFloatSetting', $setting->getName());
        $this->assertSame('Awesome float', $setting->getDescription());
        $this->assertSame(1.23, $setting->getValue());
    }

    public function testIntegerSetting(): void
    {
        $setting = new IntegerSetting('coolIntegerSetting', 'Awesome integer', 123);

        $this->assertSame('coolIntegerSetting', $setting->getName());
        $this->assertSame('Awesome integer', $setting->getDescription());
        $this->assertSame(123, $setting->getValue());
    }

    public function testStringSetting(): void
    {
        $setting = new StringSetting('coolStringSetting', 'Awesome string',
            'this is a damn cool value');

        $this->assertSame('coolStringSetting', $setting->getName());
        $this->assertSame('Awesome string', $setting->getDescription());
        $this->assertSame('this is a damn cool value', $setting->getValue());
    }

    public function testStringSettingAsCollection(): void
    {
        $setting = new StringSetting('coolCollectionSetting', 'Awesome collection',
            'a:5:{i:0;s:4:"info";i:1;s:5:"start";i:2;s:7:"details";i:3;s:5:"alist";i:4;s:10:"vendorlist";');

        $this->assertSame('coolCollectionSetting', $setting->getName());
        $this->assertSame('Awesome collection', $setting->getDescription());
        $this->assertSame(
            'a:5:{i:0;s:4:"info";i:1;s:5:"start";i:2;s:7:"details";i:3;s:5:"alist";i:4;s:10:"vendorlist";',
            $setting->getValue()
        );
    }

    public function testSettingType(): void
    {
        $settingType = new SettingType('coolSettingType', 'setting type description', FieldType::BOOLEAN);

        $this->assertSame('coolSettingType', $settingType->getName());
        $this->assertSame('setting type description', $settingType->getDescription());
        $this->assertSame( 'bool', $settingType->getType()
        );
    }

    public function testInvalidSettingType(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The value "invalidType" is not a valid field type.
Please use one of the following types: "'.implode('", "', FieldType::getEnums()).'".');

        new SettingType('coolSettingType', 'setting type description', 'invalidType');
    }
}
