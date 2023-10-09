<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use Symfony\Component\String\UnicodeString;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingRepositoryTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

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
        $serviceFloatSetting = $this->getFloatSetting();

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $nameID = new ID('floatSetting');
        $floatSetting = $moduleRepository->getFloatSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getBooleanSetting();

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getBoolean')
            ->willReturn(false);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $moduleRepository->getBooleanSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getString')
            ->willReturn(new UnicodeString('default'));

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $nameID = new ID('stringSetting');
        $stringSetting = $moduleRepository->getStringSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetModuleSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getCollection')
            ->willReturn(['nice', 'values']);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $nameID = new ID('arraySetting');
        $collectionSetting = $moduleRepository->getCollectionSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceCollectionSetting, $collectionSetting);
    }
}
