<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ShopSettingServiceTest extends UnitTestCase
{
    public function testGetShopSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getInteger')
            ->willReturn(123);

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getIntegerSetting($nameID);

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetShopSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getFloatSetting($nameID);

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetShopSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativBooleanSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBoolean')
            ->willReturn(False);

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingService->getBooleanSetting($nameID);

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetShopSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getString')
            ->willReturn('default');

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingService->getStringSetting($nameID);

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetShopSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSelect')
            ->willReturn('select');

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('selectSetting');
        $selectSetting = $settingService->getSelectSetting($nameID);

        $this->assertEquals($serviceSelectSetting, $selectSetting);
    }

    public function testGetShopSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getCollection')
            ->willReturn(['nice', 'values']);

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingService->getCollectionSetting($nameID);

        $this->assertEquals($serviceCollectionSetting, $collectionSetting);
    }

    public function testGetShopSettingAssocCollection(): void
    {
        $serviceAssocCollectionSetting = $this->getAssocCollectionSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getAssocCollection')
            ->willReturn(['first'=>'10','second'=>'20','third'=>'50']);

        $settingService = new ShopSettingService($repository);

        $nameID = new ID('aarraySetting');
        $assocCollectionSetting = $settingService->getAssocCollectionSetting($nameID);

        $this->assertEquals($serviceAssocCollectionSetting, $assocCollectionSetting);
    }
}
