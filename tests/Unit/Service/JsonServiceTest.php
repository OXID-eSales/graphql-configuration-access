<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\CollectionEncodingException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonService;
use PHPUnit\Framework\TestCase;

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
}
