<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\CollectionEncodingException;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\InvalidCollectionException;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\JsonCollectionEncodingService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\JsonCollectionEncodingService
 */
class JsonCollectionEncodingServiceTest extends TestCase
{
    public function testJsonEncodeArray(): void
    {
        $sut = new JsonCollectionEncodingService();
        $value = ['some' => 'value'];

        $this->assertSame('{"some":"value"}', $sut->encodeArrayToString($value));
    }

    public function testJsonEncodeArrayException(): void
    {
        $sut = new JsonCollectionEncodingService();
        $value = [&$value];

        $this->expectException(CollectionEncodingException::class);
        $sut->encodeArrayToString($value);
    }

    /** @dataProvider jsonDecodeCollectionDataProvider */
    public function testJsonDecodeCollection(string $value, array $expectedResult): void
    {
        $sut = new JsonCollectionEncodingService();

        $this->assertEquals($expectedResult, $sut->decodeStringCollectionToArray($value));
    }

    public function jsonDecodeCollectionDataProvider(): \Generator
    {
        yield [
            'value' => '',
            'result' => []
        ];

        yield [
            'value' => '["apple","banana"]',
            'result' => ["apple", "banana"]
        ];

        yield [
            'value' => '{"name":"John","age":30}',
            'result' => ["name" => "John", "age" => 30]
        ];
    }

    public function testJsonDecodeCollectionException(): void
    {
        $sut = new JsonCollectionEncodingService();
        $value = '[2, "values"';

        $this->expectException(InvalidCollectionException::class);
        $sut->decodeStringCollectionToArray($value);
    }
}
