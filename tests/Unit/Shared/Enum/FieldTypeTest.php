<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Enum;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType::class)]
class FieldTypeTest extends TestCase
{
    #[DataProvider('fieldTypesDataProvider')]
    public function testValidType(string $type): void
    {
        $this->assertTrue(FieldType::validateFieldType($type));
    }

    public function testInvalidType(): void
    {
        $this->assertFalse(FieldType::validateFieldType('INVALID_FIELDTYPE'));
    }

    #[DataProvider('fieldTypesDataProvider')]
    public function testGetEnums(string $type): void
    {
        $enums = FieldType::getEnums();

        $this->assertContains($type, $enums);
    }

    public static function fieldTypesDataProvider(): \Generator
    {
        yield [FieldType::ASSOCIATIVE_ARRAY];
        yield [FieldType::NUMBER];
        yield [FieldType::ARRAY];
        yield [FieldType::STRING];
        yield [FieldType::BOOLEAN];
        yield [FieldType::SELECT];
    }
}
