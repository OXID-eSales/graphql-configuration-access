<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting::class)]
class StringSettingTest extends TestCase
{
    #[DataProvider('stringSettingDataProvider')]
    public function testStringSetting(string $name, $value): void
    {
        $sut = new StringSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public static function stringSettingDataProvider(): \Generator
    {
        yield "random strings" => [uniqid(), uniqid()];
    }
}
