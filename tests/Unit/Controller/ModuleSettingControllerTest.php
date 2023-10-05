<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ModuleSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
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
}
