<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ShopSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ShopSettingControllerTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
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
}
