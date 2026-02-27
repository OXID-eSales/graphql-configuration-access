<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting::class)]
class IntegerSettingTest extends TestCase
{
    #[DataProvider('integerSettingDataProvider')]
    public function testIntegerSetting(string $name, int $value): void
    {
        $sut = new IntegerSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public static function integerSettingDataProvider(): \Generator
    {
        yield "random integer" => [uniqid(), rand(1, 100)];
    }
}
