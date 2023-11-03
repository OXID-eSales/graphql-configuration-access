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

class FieldTypeTestTest extends TestCase
{
    public function testValidType(): void
    {
        $this->assertTrue(FieldType::validateFieldType(FieldType::BOOLEAN));
        $this->assertTrue(FieldType::validateFieldType(FieldType::NUMBER));
        $this->assertTrue(FieldType::validateFieldType(FieldType::STRING));
        $this->assertTrue(FieldType::validateFieldType(FieldType::SELECT));
        $this->assertTrue(FieldType::validateFieldType(FieldType::ASSOCIATIVE_ARRAY));
        $this->assertTrue(FieldType::validateFieldType(FieldType::ARRAY));
    }

    public function testInvalidType(): void
    {
        $this->assertFalse(FieldType::validateFieldType('INVALID_FIELDTYPE'));
    }

    public function testGetEnums(): void
    {
        $enums = FieldType::getEnums();

        $this->assertIsArray($enums);
        $this->assertContains(FieldType::ASSOCIATIVE_ARRAY, $enums);
        $this->assertContains(FieldType::NUMBER, $enums);
        $this->assertContains(FieldType::ARRAY, $enums);
        $this->assertContains(FieldType::STRING, $enums);
        $this->assertContains(FieldType::BOOLEAN, $enums);
        $this->assertContains(FieldType::SELECT, $enums);
    }
}
