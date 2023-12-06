<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\WrongSettingTypeException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository
 */
class ShopSettingRepositoryGettersTest extends AbstractShopSettingRepositoryTestCase
{
    /**
     * @dataProvider possibleGetIntegerValuesDataProvider
     * @dataProvider possibleGetFloatValuesDataProvider
     * @dataProvider possibleGetBooleanValuesDataProvider
     * @dataProvider possibleGetStringValuesDataProvider
     * @dataProvider possibleGetSelectValuesDataProvider
     * @dataProvider possibleGetCollectionValuesDataProvider
     * @dataProvider possibleGetAssocCollectionValuesDataProvider
     */
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
            basicContext: $this->getBasicContextMock($shopId),
            shopSettingDao: $shopSettingDaoStub
        );

        $this->assertSame($expectedResult, $sut->$method($settingName));
    }

    /**
     * @dataProvider wrongSettingsTypeDataProvider
     * @dataProvider wrongSettingsValueDataProvider
     */
    public function testGetShopSettingWrongData(
        string $method,
        string $type,
        $value,
        string $expectedException
    ): void {
        $shopSettingDaoStub = $this->createStub(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')->willReturn(
            $this->createConfiguredMock(ShopConfigurationSetting::class, [
                'getType' => $type,
                'getValue' => $value
            ])
        );

        $sut = $this->getSut(
            shopSettingDao: $shopSettingDaoStub
        );

        $this->expectException($expectedException);
        $sut->$method('settingName');
    }

    public function wrongSettingsTypeDataProvider(): \Generator
    {
        yield [
            'method' => 'getInteger',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getFloat',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getBoolean',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getString',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getSelect',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getCollection',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];
    }
}
