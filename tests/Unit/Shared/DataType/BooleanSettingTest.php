<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting
 */
class BooleanSettingTest extends TestCase
{
    /** @dataProvider booleanSettingDataProvider */
    public function testBooleanSetting(string $name, bool $value): void
    {
        $sut = new BooleanSetting($name, $value);

        $this->assertSame($name, $sut->getName());
        $this->assertSame($value, $sut->getValue());
    }

    public function booleanSettingDataProvider(): \Generator
    {
        yield [uniqid(), true];
        yield [uniqid(), false];
    }
}
