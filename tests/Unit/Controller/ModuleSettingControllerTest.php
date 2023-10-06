<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ModuleSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingServiceInterface;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingControllerTest extends TestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = new IntegerSetting('integerSetting', '', 123);

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getModuleIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingController->getModuleSettingInteger($nameID, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = new FloatSetting('floatSetting', '', 1.23);

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getModuleFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingController->getModuleSettingFloat($nameID, 'awesomeModule');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = new BooleanSetting('booleanSetting', '', false);

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getModuleBooleanSetting')
            ->willReturn($serviceBooleanSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingController->getModuleSettingBoolean($nameID, 'awesomeModule');

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = new StringSetting('stringSetting', '', 'default');

        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getModuleStringSetting')
            ->willReturn($serviceStringSetting);

        $settingController = new ModuleSettingController($settingService);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingController->getModuleSettingString($nameID, 'awesomeModule');

        $this->assertSame($serviceStringSetting, $stringSetting);
    }
}
