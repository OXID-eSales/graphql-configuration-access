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

        $integerSetting = $settingController->getThemeSettingInteger(
            new ID('integerSetting'),
            'awesomeTheme'
        );

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

        $floatSetting = $settingController->getThemeSettingFloat(
            new ID('floatSetting'),
            'awesomeTheme'
        );

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

        $booleanSetting = $settingController->getThemeSettingBoolean(
            new ID('booleanSetting'),
            'awesomeTheme'
        );

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

        $stringSetting = $settingController->getThemeSettingString(
            new ID('stringSetting'),
            'awesomeTheme'
        );

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

        $selectSetting = $settingController->getThemeSettingSelect(
            new ID('selectSetting'),
            'awesomeTheme'
        );

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

        $collectionSetting = $settingController->getThemeSettingCollection(
            new ID('arraySetting'),
            'awesomeTheme'
        );

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

        $assocCollectionSetting = $settingController->getThemeSettingAssocCollection(
            new ID('aarraySetting'),
            'awesomeTheme'
        );

        $this->assertSame($serviceAssocCollectionSetting, $assocCollectionSetting);
    }

    public function testListThemeSettings(): void
    {
        $themeId = 'awesomeTheme';
        $serviceSettingsList = $this->getSettingTypeList();
        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getSettingsList')
            ->with($themeId)
            ->willReturn($serviceSettingsList);

        $sut = new ThemeSettingController($settingService);
        $this->assertSame($serviceSettingsList, $sut->getThemeSettingsList($themeId));
    }

    public function testChangeThemeSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ThemeSettingController($settingService);

        $integerSetting = $settingController->changeThemeSettingInteger(
            $serviceIntegerSetting->getName(),
            $serviceIntegerSetting->getValue(),
            'awesomeTheme'
        );

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

        $floatSetting = $settingController->changeThemeSettingFloat(
            $serviceFloatSetting->getName(),
            $serviceFloatSetting->getValue(),
            'awesomeTheme'
        );

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

        $booleanSetting = $settingController->changeThemeSettingBoolean(
            $serviceBooleanSetting->getName(),
            $serviceBooleanSetting->getValue(),
            'awesomeTheme'
        );

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

        $stringSetting = $settingController->changeThemeSettingString(
            $serviceStringSetting->getName(),
            $serviceStringSetting->getValue(),
            'awesomeTheme'
        );

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

        $selectSetting = $settingController->changeThemeSettingSelect(
            $serviceSelectSetting->getName(),
            $serviceSelectSetting->getValue(),
            'awesomeTheme'
        );

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

        $collectionSetting = $settingController->changeThemeSettingCollection(
            $serviceCollectionSetting->getName(),
            $serviceCollectionSetting->getValue(),
            'awesomeTheme'
        );

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

        $assocCollectionSetting = $settingController->changeThemeSettingAssocCollection(
            $serviceAssocCollectionSetting->getName(),
            $serviceAssocCollectionSetting->getValue(),
            'awesomeTheme'
        );

        $this->assertSame($assocCollectionSetting, $serviceAssocCollectionSetting);
    }
}
