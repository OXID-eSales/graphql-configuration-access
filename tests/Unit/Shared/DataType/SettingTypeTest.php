<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType
 */
class SettingTypeTest extends TestCase
{
    public function testGetters(): void
    {
        $settingIdentifier = 'someSettingName';
        $settingType = 'someRandomType';

        $sut = new SettingType(
            $settingIdentifier,
            $settingType
        );

        $this->assertEquals($settingIdentifier, $sut->getName());
        $this->assertEquals($settingType, $sut->getType());
    }

    /** @dataProvider isSupportedDataProvider */
    public function testIsSupported(string $settingType, bool $expectation): void
    {
        $sut = new SettingType(
            'someSettingName',
            $settingType
        );

        $this->assertSame($expectation, $sut->isSupported());
    }

    public function isSupportedDataProvider(): \Generator
    {
        yield 'not supported case' => ['settingType' => 'someRandomSettingId', 'expectation' => false];
        yield 'supported case' => ['settingType' => FieldType::ARRAY, 'expectation' => true];
    }
}
