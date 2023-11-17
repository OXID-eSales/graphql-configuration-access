<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository
 */
class ShopSettingRepositorySettersTest extends AbstractShopSettingRepositoryTest
{
    /** @dataProvider shopSettingsSaveMethodsDataProvider */
    public function testSetShopSetting(string $method, $settingValue, string $settingType): void
    {
        $shopId = 3;
        $settingName = 'settingName';

        $setting = $this->buildShopSettingStub($shopId, $settingType, $settingName, $settingValue);

        $basicContextStub = $this->createStub(BasicContextInterface::class);
        $basicContextStub->method('getCurrentShopId')->willReturn($shopId);

        $shopSettingDaoSpy = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoSpy->expects($this->once())->method('save')->with($setting);

        $sut = $this->getSut(
            basicContext: $basicContextStub,
            shopSettingDao: $shopSettingDaoSpy
        );

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
