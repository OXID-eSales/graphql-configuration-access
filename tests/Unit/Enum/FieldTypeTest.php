<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType
 */
class FieldTypeTest extends TestCase
{
    /** @dataProvider fieldTypesDataProvider */
    public function testValidType(string $type): void
    {
        $this->assertTrue(FieldType::validateFieldType($type));
    }

    public function testInvalidType(): void
    {
        $this->assertFalse(FieldType::validateFieldType('INVALID_FIELDTYPE'));
    }

    /** @dataProvider fieldTypesDataProvider */
    public function testGetEnums(string $type): void
    {
        $enums = FieldType::getEnums();

        $this->assertContains($type, $enums);
    }

    public function fieldTypesDataProvider(): \Generator
    {
        yield [FieldType::ASSOCIATIVE_ARRAY];
        yield [FieldType::NUMBER];
        yield [FieldType::ARRAY];
        yield [FieldType::STRING];
        yield [FieldType::BOOLEAN];
        yield [FieldType::SELECT];
    }
}
