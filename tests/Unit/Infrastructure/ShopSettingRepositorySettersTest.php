<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingTypeException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository
 */
class ShopSettingRepositorySettersTest extends AbstractShopSettingRepositoryTest
{
    /** @dataProvider shopSettingsSaveMethodsDataProvider */
    public function testSetShopSetting(
        string $method,
        $settingValue,
        string $settingType
    ): void {
        $shopId = 3;
        $settingName = 'settingName';

        $settingToSave = $this->buildShopSettingStub($shopId, $settingType, $settingName, $settingValue);

        $shopSettingDaoSpy = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoSpy->method('get')->with($settingName, $shopId)->willReturn($settingToSave);
        $shopSettingDaoSpy->expects($this->once())->method('save')->with($settingToSave);

        $sut = $this->getSut(
            basicContext: $this->getBasicContextMock($shopId),
            shopSettingDao: $shopSettingDaoSpy
        );

        $sut->$method($settingName, $settingValue);
    }

    /** @dataProvider shopSettingsSaveMethodsDataProvider */
    public function testSetShopIsNotCalledOnOriginalSettingTypeMissmatch(
        string $method,
        $settingValue,
        string $settingType
    ): void {
        $shopId = 3;
        $settingName = 'settingName';

        $originalSetting = $this->buildShopSettingStub($shopId, 'differentType', $settingName, $settingValue);

        $settingToSave = $this->buildShopSettingStub($shopId, $settingType, $settingName, $settingValue);

        $shopSettingDaoSpy = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoSpy->method('get')->with($settingName, $shopId)->willReturn($originalSetting);
        $shopSettingDaoSpy->expects($this->never())->method('save')->with($settingToSave);

        $sut = $this->getSut(
            basicContext: $this->getBasicContextMock($shopId),
            shopSettingDao: $shopSettingDaoSpy
        );

        $this->expectException(WrongSettingTypeException::class);
        $sut->$method($settingName, $settingValue);
    }

    public function shopSettingsSaveMethodsDataProvider(): \Generator
    {
        yield 'integer' => [
            'method' => 'saveIntegerSetting',
            'settingValue' => 123,
            'settingType' => FieldType::NUMBER
        ];

        yield 'float' => [
            'method' => 'saveFloatSetting',
            'settingValue' => 1.23,
            'settingType' => FieldType::NUMBER
        ];

        yield 'boolean' => [
            'method' => 'saveBooleanSetting',
            'settingValue' => true,
            'settingType' => FieldType::BOOLEAN
        ];

        yield 'string' => [
            'method' => 'saveStringSetting',
            'settingValue' => 'string value',
            'settingType' => FieldType::STRING
        ];

        yield 'select' => [
            'method' => 'saveSelectSetting',
            'settingValue' => 'string select value',
            'settingType' => FieldType::SELECT
        ];

        yield 'collection' => [
            'method' => 'saveCollectionSetting',
            'settingValue' => ['some', 'collection'],
            'settingType' => FieldType::ARRAY
        ];

        yield 'assoc collection' => [
            'method' => 'saveAssocCollectionSetting',
            'settingValue' => ['key1' => 'some', 'key2' => 'collection'],
            'settingType' => FieldType::ASSOCIATIVE_ARRAY
        ];
    }

    public function buildShopSettingStub(
        int $shopId,
        string $settingType,
        string $settingName,
        $settingValue
    ): ShopConfigurationSetting {
        return (new ShopConfigurationSetting())
            ->setShopId($shopId)
            ->setName($settingName)
            ->setType($settingType)
            ->setValue($settingValue);
    }
}
