<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingRepositoryTest extends TestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = new IntegerSetting('integerSetting', '', 123);

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getInteger')
            ->willReturn(123);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $nameID = new ID('integerSetting');
        $integerSetting = $moduleRepository->getIntegerSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = new FloatSetting('floatSetting', '', 1.23);

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $moduleRepository->getFloatSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }
}
