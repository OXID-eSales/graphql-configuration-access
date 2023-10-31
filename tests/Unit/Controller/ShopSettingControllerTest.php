<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ShopSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ShopSettingControllerTest extends UnitTestCase
{
    public function testGetShopSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ShopSettingController($settingService);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingController->getShopSettingInteger($nameID);

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetShopSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingController = new ShopSettingController($settingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingController->getShopSettingFloat($nameID);

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testGetShopSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativBooleanSetting();

        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getBooleanSetting')
            ->willReturn($serviceBooleanSetting);

        $settingController = new ShopSettingController($settingService);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingController->getShopSettingBoolean($nameID);

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetShopSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getStringSetting')
            ->willReturn($serviceStringSetting);

        $settingController = new ShopSettingController($settingService);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingController->getShopSettingString($nameID);

        $this->assertSame($serviceStringSetting, $stringSetting);
    }

    public function testGetShopSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getSelectSetting')
            ->willReturn($serviceSelectSetting);

        $settingController = new ShopSettingController($settingService);

        $nameID = new ID('selectSetting');
        $selectSetting = $settingController->getShopSettingSelect($nameID);

        $this->assertSame($serviceSelectSetting, $selectSetting);
    }

    public function testGetShopSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getCollectionSetting')
            ->willReturn($serviceCollectionSetting);

        $settingController = new ShopSettingController($settingService);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingController->getShopSettingCollection($nameID);

        $this->assertSame($serviceCollectionSetting, $collectionSetting);
    }
}
