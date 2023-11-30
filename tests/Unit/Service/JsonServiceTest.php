<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\CollectionEncodingException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollectionException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonService
 */
class JsonServiceTest extends TestCase
{
    public function testJsonEncodeArray(): void
    {
        $sut = new JsonService();
        $value = ['some' => 'value'];

        $this->assertSame('{"some":"value"}', $sut->jsonEncodeArray($value));
    }

    public function testJsonEncodeArrayException(): void
    {
        $sut = new JsonService();
        $value = [&$value];

        $this->expectException(CollectionEncodingException::class);
        $sut->jsonEncodeArray($value);
    }

    /** @dataProvider jsonDecodeCollectionDataProvider */
    public function testJsonDecodeCollection(string $value, array $expectedResult): void
    {
        $sut = new JsonService();

        $this->assertEquals($expectedResult, $sut->jsonDecodeCollection($value));
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
        $sut = new JsonService();
        $value = '[2, "values"';

        $this->expectException(InvalidCollectionException::class);
        $sut->jsonDecodeCollection($value);
    }
}
