<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\DatabaseFieldType;
use PHPUnit\Framework\TestCase;

class DatabaseFieldTypeTest extends TestCase
{
    public function testValidType(): void
    {
        $this->assertTrue(DatabaseFieldType::validateFieldType(DatabaseFieldType::BOOLEAN));
        $this->assertTrue(DatabaseFieldType::validateFieldType(DatabaseFieldType::NUMBER));
        $this->assertTrue(DatabaseFieldType::validateFieldType(DatabaseFieldType::STRING));
        $this->assertTrue(DatabaseFieldType::validateFieldType(DatabaseFieldType::SELECT));
        $this->assertTrue(DatabaseFieldType::validateFieldType(DatabaseFieldType::ASSOCIATIVE_ARRAY));
        $this->assertTrue(DatabaseFieldType::validateFieldType(DatabaseFieldType::ARRAY));
    }

    public function testInvalidType(): void
    {
        $this->assertFalse(DatabaseFieldType::validateFieldType('INVALID_FIELDTYPE'));
    }

    public function testGetEnums(): void
    {
        $enums = DatabaseFieldType::getEnums();

        $this->assertIsArray($enums);
        $this->assertContains(DatabaseFieldType::ASSOCIATIVE_ARRAY, $enums);
        $this->assertContains(DatabaseFieldType::NUMBER, $enums);
        $this->assertContains(DatabaseFieldType::ARRAY, $enums);
        $this->assertContains(DatabaseFieldType::STRING, $enums);
        $this->assertContains(DatabaseFieldType::BOOLEAN, $enums);
        $this->assertContains(DatabaseFieldType::SELECT, $enums);
    }
}
