<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\DatabaseSettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\ModuleSettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\DatabaseFieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\ModuleFieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

class SettingTest extends UnitTestCase
{
    public function testBooleanSetting(): void
    {
        $setting = $this->getNegativBooleanSetting();

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

    public function testDatabaseSettingType(): void
    {
        $databaseSettingType = $this->getDatabaseSettingType();

        $this->assertEquals(new ID('settingType'), $databaseSettingType->getName());
        $this->assertSame( DatabaseFieldType::BOOLEAN, $databaseSettingType->getType());
    }

    public function testModuleSettingType(): void
    {
        $moduleSettingType = $this->getModuleSettingType();

        $this->assertEquals(new ID('settingType'), $moduleSettingType->getName());
        $this->assertSame( DatabaseFieldType::BOOLEAN, $moduleSettingType->getType());
    }

    public function testInvalidDatabaseSettingType(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The value "invalidType" is not a valid field type.
Please use one of the following types: "'.implode('", "', DatabaseFieldType::getEnums()).'".');

        new DatabaseSettingType(new ID('coolSettingType'), 'invalidType');
    }

    public function testInvalidModuleSettingType(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The value "invalidType" is not a valid field type.
Please use one of the following types: "'.implode('", "', ModuleFieldType::getEnums()).'".');

        new ModuleSettingType(new ID('coolSettingType'), 'invalidType');
    }
}
