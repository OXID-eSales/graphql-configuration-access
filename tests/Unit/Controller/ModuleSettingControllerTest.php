<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ModuleSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingControllerTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingController->getModuleSettingInteger($nameID, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingController->getModuleSettingFloat($nameID, 'awesomeModule');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getBooleanSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getBooleanSetting')
            ->willReturn($serviceBooleanSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingController->getModuleSettingBoolean($nameID, 'awesomeModule');

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getStringSetting')
            ->willReturn($serviceStringSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingController->getModuleSettingString($nameID, 'awesomeModule');

        $this->assertSame($serviceStringSetting, $stringSetting);
    }

    public function testGetModuleSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getCollectionSetting')
            ->willReturn($serviceCollectionSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingController->getModuleSettingCollection($nameID, 'awesomeModule');

        $this->assertSame($serviceCollectionSetting, $collectionSetting);
    }

    public function testChangeModuleSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('intSetting');
        $integerSetting = $settingController->changeModuleSettingInteger($nameID, 123, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testChangeModuleSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('changeFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingController->changeModuleSettingFloat($nameID, 1.23, 'awesomeModule');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }
}
