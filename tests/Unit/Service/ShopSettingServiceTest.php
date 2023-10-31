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
}
