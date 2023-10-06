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
        $serviceBooleanSetting = $this->getNegativeBooleanSetting();

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

    public function testGetThemeSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getCollectionSetting')
            ->willReturn($serviceCollectionSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingController->getThemeSettingCollection($nameID, 'awesomeTheme');

        $this->assertSame($serviceCollectionSetting, $collectionSetting);
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $serviceAssocCollectionSetting = $this->getAssocCollectionSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getAssocCollectionSetting')
            ->willReturn($serviceAssocCollectionSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = new ID('aarraySetting');
        $assocCollectionSetting = $settingController->getThemeSettingAssocCollection($nameID, 'awesomeTheme');

        $this->assertSame($serviceAssocCollectionSetting, $assocCollectionSetting);
    }

    public function testChangeThemeSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceIntegerSetting->getName();
        $value = $serviceIntegerSetting->getValue();
        $integerSetting = $settingController->changeThemeSettingInteger($nameID, $value, 'awesomeTheme');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testChangeThemeSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceFloatSetting->getName();
        $value = $serviceFloatSetting->getValue();
        $floatSetting = $settingController->changeThemeSettingFloat($nameID, $value, 'awesomeTheme');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testChangeThemeSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getPositiveBooleanSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeBooleanSetting')
            ->willReturn($serviceBooleanSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceBooleanSetting->getName();
        $value = $serviceBooleanSetting->getValue();
        $booleanSetting = $settingController->changeThemeSettingBoolean($nameID, $value, 'awesomeTheme');

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testChangeThemeSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeStringSetting')
            ->willReturn($serviceStringSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceStringSetting->getName();
        $value = $serviceStringSetting->getValue();
        $stringSetting = $settingController->changeThemeSettingString($nameID, $value, 'awesomeTheme');

        $this->assertSame($serviceStringSetting, $stringSetting);
    }

    public function testChangeThemeSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeSelectSetting')
            ->willReturn($serviceSelectSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceSelectSetting->getName();
        $value = $serviceSelectSetting->getValue();
        $selectSetting = $settingController->changeThemeSettingSelect($nameID, $value, 'awesomeTheme');

        $this->assertSame($serviceSelectSetting, $selectSetting);
    }

    public function testChangeThemeSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeCollectionSetting')
            ->willReturn($serviceCollectionSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceCollectionSetting->getName();
        $value = $serviceCollectionSetting->getValue();
        $collectionSetting = $settingController->changeThemeSettingCollection($nameID, $value, 'awesomeTheme');

        $this->assertSame($collectionSetting, $serviceCollectionSetting);
    }

    public function testChangeThemeSettingAssocCollection(): void
    {
        $serviceAssocCollectionSetting = $this->getAssocCollectionSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeAssocCollectionSetting')
            ->willReturn($serviceAssocCollectionSetting);

        $settingController = new ThemeSettingController($settingService);

        $nameID = $serviceAssocCollectionSetting->getName();
        $value = $serviceAssocCollectionSetting->getValue();
        $assocCollectionSetting = $settingController->changeThemeSettingAssocCollection($nameID, $value, 'awesomeTheme');

        $this->assertSame($assocCollectionSetting, $serviceAssocCollectionSetting);
    }
}
