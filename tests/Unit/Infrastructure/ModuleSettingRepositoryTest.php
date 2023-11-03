<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\String\UnicodeString;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingRepositoryTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getInteger')
            ->willReturn(123);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $nameID = new ID('integerSetting');
        $integerSetting = $moduleRepository->getIntegerSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $nameID = new ID('floatSetting');
        $floatSetting = $moduleRepository->getFloatSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativBooleanSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getBoolean')
            ->willReturn(false);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $nameID = new ID('booleanSetting');
        $booleanSetting = $moduleRepository->getBooleanSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getString')
            ->willReturn(new UnicodeString('default'));

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $nameID = new ID('stringSetting');
        $stringSetting = $moduleRepository->getStringSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetModuleSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getCollection')
            ->willReturn(['nice', 'values']);

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $nameID = new ID('arraySetting');
        $collectionSetting = $moduleRepository->getCollectionSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceCollectionSetting, $collectionSetting);
    }

    public function testChangeModuleSettingInteger(): void
    {
        $nameID = new ID('intSetting');

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveInteger')
            ->with($nameID->val(), 123, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $moduleRepository->saveIntegerSetting($nameID, 123, 'awesomeModule');
    }

    public function testChangeModuleSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveFloat')
            ->with($nameID->val(), 1.23, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $moduleRepository->saveFloatSetting($nameID, 1.23, 'awesomeModule');
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $nameID = new ID('boolSetting');
        $value = false;

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveBoolean')
            ->with($nameID->val(), $value, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $moduleRepository->saveBooleanSetting($nameID, $value, 'awesomeModule');
    }

    public function testChangeModuleSettingString(): void
    {
        $nameID = new ID('stringSetting');
        $value = 'default';

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveString')
            ->with($nameID->val(), $value, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $moduleRepository->saveStringSetting($nameID, $value, 'awesomeModule');
    }

    public function testChangeModuleSettingCollection(): void
    {
        $nameID = new ID('boolSetting');
        $value = [3, 'interesting', 'values'];

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveCollection')
            ->with($nameID->val(), $value, 'awesomeModule');

        $moduleRepository = new ModuleSettingRepository($moduleSettingService, $this->getModueConfigurationDaoMock());

        $moduleRepository->saveCollectionSetting($nameID, $value, 'awesomeModule');
    }

    public function testGetSettingsList(): void
    {
        $intSetting = (new Setting())->setName('intSetting')->setType(FieldType::NUMBER);
        $stringSetting = (new Setting())->setName('stringSetting')->setType(FieldType::STRING);
        $arraySetting = (new Setting())->setName('arraySetting')->setType(FieldType::ARRAY);

        $moduleConfiguration = $this->createMock(ModuleConfiguration::class);
        $moduleConfiguration->expects($this->once())
            ->method('getModuleSettings')
            ->willReturn([$intSetting, $stringSetting, $arraySetting]);
        $moduleConfigurationDao = $this->getModueConfigurationDaoMock();
        $moduleConfigurationDao->expects($this->once())
            ->method('get')
            ->willReturn($moduleConfiguration);

        $moduleRepository = new ModuleSettingRepository($this->getModuleSettingServiceMock(), $moduleConfigurationDao);
        $settingsList = $moduleRepository->getSettingsList('awesomeModule');
        $this->assertEquals([$intSetting, $stringSetting, $arraySetting], $settingsList);
    }

    /**
     * @return ModuleConfigurationDaoInterface|(ModuleConfigurationDaoInterface&MockObject)|MockObject
     */
    public function getModueConfigurationDaoMock(): ModuleConfigurationDaoInterface|MockObject
    {
        return $this->createMock(ModuleConfigurationDaoInterface::class);
    }

    /**
     * @return ModuleSettingServiceInterface|(ModuleSettingServiceInterface&MockObject)|MockObject
     */
    public function getModuleSettingServiceMock(): MockObject|ModuleSettingServiceInterface
    {
        return $this->createMock(ModuleSettingServiceInterface::class);
    }

}
