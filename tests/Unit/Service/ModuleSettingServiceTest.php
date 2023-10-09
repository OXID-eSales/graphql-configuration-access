<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingServiceTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getIntegerSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloatSetting')
            ->willReturn($serviceFloatSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getFloatSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getBooleanSetting();

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBooleanSetting')
            ->willReturn($serviceBooleanSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingService->getBooleanSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getStringSetting')
            ->willReturn($serviceStringSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingService->getStringSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceStringSetting, $stringSetting);
    }

    public function testGetModuleSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getCollectionSetting')
            ->willReturn($serviceCollectionSetting);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingService->getCollectionSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceCollectionSetting, $collectionSetting);
    }
}
