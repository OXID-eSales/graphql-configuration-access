<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shop\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception\WrongSettingTypeException;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[AllowMockObjectsWithoutExpectations]
#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Shop\Infrastructure\ShopSettingRepository::class)]
class ShopSettingRepositoryGettersTest extends AbstractShopSettingRepositoryTestCase
{
    #[DataProvider('allGetValuesDataProvider')]
    public function testGetShopSetting($method, $type, $possibleValue, $expectedResult): void
    {
        $settingName = 'settingName';
        $shopId = 3;

        $shopSettingDaoStub = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')
            ->with($settingName, $shopId)
            ->willReturn(
                $this->createConfiguredMock(ShopConfigurationSetting::class, [
                    'getName' => $settingName,
                    'getType' => $type,
                    'getValue' => $possibleValue
                ])
            );

        $sut = $this->getSut(
            context: $this->getContextMock($shopId),
            shopSettingDao: $shopSettingDaoStub
        );

        $this->assertSame($expectedResult, $sut->$method($settingName));
    }

    #[DataProvider('wrongSettingsDataProvider')]
    public function testGetShopSettingWrongData(
        string $method,
        string $type,
        mixed $possibleValue,
        string $expectedException
    ): void {
        $shopSettingDaoStub = $this->createStub(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')->willReturn(
            $this->createConfiguredMock(ShopConfigurationSetting::class, [
                'getType' => $type,
                'getValue' => $possibleValue
            ])
        );

        $sut = $this->getSut(
            shopSettingDao: $shopSettingDaoStub
        );

        $this->expectException($expectedException);
        $sut->$method('settingName');
    }

    public static function allGetValuesDataProvider(): \Generator
    {
        foreach (self::possibleGetIntegerValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::possibleGetFloatValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::possibleGetBooleanValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::possibleGetStringValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::possibleGetSelectValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::possibleGetCollectionValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::possibleGetAssocCollectionValuesDataProvider() as $key => $data) {
            yield $key => $data;
        }
    }

    public static function wrongSettingsDataProvider(): \Generator
    {
        foreach (self::wrongSettingsTypeDataProvider() as $key => $data) {
            yield $key => $data;
        }
        foreach (self::wrongSettingsValueDataProvider() as $key => $data) {
            yield $key => $data;
        }
    }

    public static function wrongSettingsTypeDataProvider(): \Generator
    {
        yield [
            'method' => 'getInteger',
            'type' => 'wrong',
            'possibleValue' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getFloat',
            'type' => 'wrong',
            'possibleValue' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getBoolean',
            'type' => 'wrong',
            'possibleValue' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getString',
            'type' => 'wrong',
            'possibleValue' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getSelect',
            'type' => 'wrong',
            'possibleValue' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getCollection',
            'type' => 'wrong',
            'possibleValue' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];
    }
}
