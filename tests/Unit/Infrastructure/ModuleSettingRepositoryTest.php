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

        $name = new ID('integerSetting');
        $integerSetting = $moduleRepository->getIntegerSetting($name, 'awesomeModule');

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

        $name = new ID('floatSetting');
        $floatSetting = $moduleRepository->getFloatSetting($name, 'awesomeModule');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativeBooleanSetting();

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('getBoolean')
            ->willReturn(false);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $name = new ID('booleanSetting');
        $booleanSetting = $moduleRepository->getBooleanSetting($name, 'awesomeModule');

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

        $name = new ID('stringSetting');
        $stringSetting = $moduleRepository->getStringSetting($name, 'awesomeModule');

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

        $name = new ID('arraySetting');
        $collectionSetting = $moduleRepository->getCollectionSetting($name, 'awesomeModule');

        $this->assertEquals($serviceCollectionSetting, $collectionSetting);
    }

    public function testChangeModuleSettingInteger(): void
    {
        $name = new ID('intSetting');

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveInteger')
            ->with($name->val(), 123, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $moduleRepository->saveIntegerSetting($name, 123, 'awesomeModule');
    }

    public function testChangeModuleSettingFloat(): void
    {
        $name = new ID('floatSetting');

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveFloat')
            ->with($name->val(), 1.23, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $moduleRepository->saveFloatSetting($name, 1.23, 'awesomeModule');
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $name = new ID('boolSetting');
        $value = false;

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveBoolean')
            ->with($name->val(), $value, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $moduleRepository->saveBooleanSetting($name, $value, 'awesomeModule');
    }

    public function testChangeModuleSettingString(): void
    {
        $name = new ID('stringSetting');
        $value = 'default';

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveString')
            ->with($name->val(), $value, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $moduleRepository->saveStringSetting($name, $value, 'awesomeModule');
    }

    public function testChangeModuleSettingCollection(): void
    {
        $name = new ID('boolSetting');
        $value = [3, 'interesting', 'values'];

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveCollection')
            ->with($name->val(), $value, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService);

        $moduleRepository->saveCollectionSetting($name, $value, 'awesomeModule');
    }
}
