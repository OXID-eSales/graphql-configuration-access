<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Enum;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType
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
