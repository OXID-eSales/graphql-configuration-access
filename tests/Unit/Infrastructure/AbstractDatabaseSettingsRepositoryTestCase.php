<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingValueException;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;

class AbstractDatabaseSettingsRepositoryTestCase extends UnitTestCase
{
    public function possibleGetFloatValuesDataProvider(): \Generator
    {
        yield 'float regular' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => 123.2,
            'expectedResult' => 123.2
        ];
        yield 'float from integer' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => 123,
            'expectedResult' => 123.0
        ];
        yield 'float from string' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => '123.3',
            'expectedResult' => 123.3
        ];
        yield 'float from int string' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => '123',
            'expectedResult' => 123.0
        ];
    }

    public function possibleGetAssocCollectionValuesDataProvider(): \Generator
    {
        yield 'empty string for assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => '',
            'expectedResult' => []
        ];

        yield 'empty array for assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => [],
            'expectedResult' => []
        ];

        yield 'filled not assoc array for assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => ['one', 'two'],
            'expectedResult' => ['one', 'two']
        ];

        yield 'associative array in assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => ['one' => 'oneValue', 'two' => 'twoValue'],
            'expectedResult' => ['one' => 'oneValue', 'two' => 'twoValue']
        ];
    }

    public function possibleGetSelectValuesDataProvider(): \Generator
    {
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => 1,
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => '1',
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => 'regular',
            'expectedResult' => 'regular'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => '0',
            'expectedResult' => '0'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => null,
            'expectedResult' => ''
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => '',
            'expectedResult' => ''
        ];
    }

    public function possibleGetBooleanValuesDataProvider(): \Generator
    {
        yield 'boolean as positive int' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => 1,
            'expectedResult' => true
        ];
        yield 'boolean as numeric string' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => '1',
            'expectedResult' => true
        ];
        yield 'boolean as true boolean' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => true,
            'expectedResult' => true
        ];
        yield 'boolean as random string' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => 'anything',
            'expectedResult' => true
        ];
        yield 'boolean as null' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => null,
            'expectedResult' => false
        ];
        yield 'boolean as int zero' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => 0,
            'expectedResult' => false
        ];
        yield 'boolean as numeric zero string' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => '0',
            'expectedResult' => false
        ];
        yield 'boolean as false boolean' => [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => false,
            'expectedResult' => false
        ];
    }

    public function possibleGetIntegerValuesDataProvider(): \Generator
    {
        yield 'int regular' => [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'possibleValue' => 123,
            'expectedResult' => 123
        ];

        yield 'int in string' => [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'possibleValue' => '123',
            'expectedResult' => 123
        ];
    }

    public function possibleGetStringValuesDataProvider(): \Generator
    {
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => 1,
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => '1',
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => 'regular',
            'expectedResult' => 'regular'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => '0',
            'expectedResult' => '0'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => null,
            'expectedResult' => ''
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => '',
            'expectedResult' => ''
        ];
    }

    public function possibleGetCollectionValuesDataProvider(): \Generator
    {
        yield 'empty string collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => '',
            'expectedResult' => []
        ];

        yield 'empty array collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => [],
            'expectedResult' => []
        ];

        yield 'filled array collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => ['one', 'two'],
            'expectedResult' => ['one', 'two']
        ];

        yield 'associative array in collection is ok' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => ['one' => 'oneValue', 'two' => 'twoValue'],
            'expectedResult' => ['one' => 'oneValue', 'two' => 'twoValue']
        ];
    }

    public function wrongSettingsValueDataProvider(): \Generator
    {
        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'value' => 'any',
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'value' => null,
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'value' => 1.123,
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'value' => '1.123',
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'value' => 'any',
            'expectedException' => WrongSettingValueException::class
        ];

        yield 'false as the error result of unserialize' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'string instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => 'some string',
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'integer instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => 123,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'float instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => 1.23,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'null instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'false as the error result of unserialize in assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'string instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => 'some string',
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'integer instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => 123,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'float instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => 1.23,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'null instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];
    }
}
