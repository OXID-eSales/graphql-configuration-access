<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingServiceTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getInteger')
            ->willReturn(123);

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getIntegerSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetThemeSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getFloatSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetThemeSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativBooleanSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBoolean')
            ->willReturn(False);

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingService->getBooleanSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetThemeSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getString')
            ->willReturn('default');

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingService->getStringSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetThemeSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSelect')
            ->willReturn('select');

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('selectSetting');
        $selectSetting = $settingService->getSelectSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceSelectSetting, $selectSetting);
    }

    public function testGetThemeSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getCollection')
            ->willReturn(['nice', 'values']);

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingService->getCollectionSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceCollectionSetting, $collectionSetting);
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $serviceAssocCollectionSetting = $this->getAssocCollectionSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getAssocCollection')
            ->willReturn(['first'=>'10','second'=>'20','third'=>'50']);

        $settingService = new ThemeSettingService($repository);

        $nameID = new ID('aarraySetting');
        $assocCollectionSetting = $settingService->getAssocCollectionSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceAssocCollectionSetting, $assocCollectionSetting);
    }
}
