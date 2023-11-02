<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\ModuleFieldType;
use PHPUnit\Framework\TestCase;

class ModuleFieldTypeTest extends TestCase
{
    public function testValidType(): void
    {
        $this->assertTrue(ModuleFieldType::validateFieldType(ModuleFieldType::INTEGER));
        $this->assertTrue(ModuleFieldType::validateFieldType(ModuleFieldType::FLOAT));
        $this->assertTrue(ModuleFieldType::validateFieldType(ModuleFieldType::BOOLEAN));
        $this->assertTrue(ModuleFieldType::validateFieldType(ModuleFieldType::STRING));
        $this->assertTrue(ModuleFieldType::validateFieldType(ModuleFieldType::ARRAY));
    }

    public function testInvalidType(): void
    {
        $this->assertFalse(ModuleFieldType::validateFieldType('INVALID_FIELDTYPE'));
    }

    public function testGetEnums(): void
    {
        $enums = ModuleFieldType::getEnums();

        $this->assertIsArray($enums);
        $this->assertContains(ModuleFieldType::INTEGER, $enums);
        $this->assertContains(ModuleFieldType::FLOAT, $enums);
        $this->assertContains(ModuleFieldType::ARRAY, $enums);
        $this->assertContains(ModuleFieldType::STRING, $enums);
        $this->assertContains(ModuleFieldType::BOOLEAN, $enums);
    }
}
