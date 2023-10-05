<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingService;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingServiceTest extends TestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = new IntegerSetting('integerSetting', '', 123);

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getModuleIntegerSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = new FloatSetting('floatSetting', '', 1.23);

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getModuleFloatSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }
}
