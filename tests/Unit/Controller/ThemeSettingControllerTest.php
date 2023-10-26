<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ThemeSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingControllerTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingController->getThemeSettingInteger($nameID, 'awesomeTheme');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetThemeSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingController->getThemeSettingFloat($nameID, 'awesomeTheme');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testGetThemeSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativBooleanSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getBooleanSetting')
            ->willReturn($serviceBooleanSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingController->getThemeSettingBoolean($nameID, 'awesomeTheme');

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetThemeSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getStringSetting')
            ->willReturn($serviceStringSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingController->getThemeSettingString($nameID, 'awesomeTheme');

        $this->assertSame($serviceStringSetting, $stringSetting);
    }

    public function testGetThemeSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getSelectSetting')
            ->willReturn($serviceSelectSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('selectSetting');
        $selectSetting = $settingController->getThemeSettingSelect($nameID, 'awesomeTheme');

        $this->assertSame($serviceSelectSetting, $selectSetting);
    }
}
