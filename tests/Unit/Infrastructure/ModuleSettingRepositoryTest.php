<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
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

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $name = new ID('integerSetting');
        $integerSetting = $moduleRepository->getIntegerSetting($name, 'awesomeModule');

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $name = new ID('floatSetting');
        $floatSetting = $moduleRepository->getFloatSetting($name, 'awesomeModule');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativeBooleanSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getBoolean')
            ->willReturn(false);

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $name = new ID('booleanSetting');
        $booleanSetting = $moduleRepository->getBooleanSetting($name, 'awesomeModule');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getString')
            ->willReturn(new UnicodeString('default'));

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $name = new ID('stringSetting');
        $stringSetting = $moduleRepository->getStringSetting($name, 'awesomeModule');

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetModuleSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('getCollection')
            ->willReturn(['nice', 'values']);

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $name = new ID('arraySetting');
        $collectionSetting = $moduleRepository->getCollectionSetting($name, 'awesomeModule');

        $this->assertEquals($serviceCollectionSetting, $collectionSetting);
    }

    public function testChangeModuleSettingInteger(): void
    {
        $name = new ID('intSetting');

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveInteger')
            ->with($name->val(), 123, 'awesomeModule');

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $moduleRepository->saveIntegerSetting($name, 123, 'awesomeModule');
    }

    public function testChangeModuleSettingFloat(): void
    {
        $name = new ID('floatSetting');

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveFloat')
            ->with($name->val(), 1.23, 'awesomeModule');

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $moduleRepository->saveFloatSetting($name, 1.23, 'awesomeModule');
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $name = new ID('boolSetting');
        $value = false;

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveBoolean')
            ->with($name->val(), $value, 'awesomeModule');

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $moduleRepository->saveBooleanSetting($name, $value, 'awesomeModule');
    }

    public function testChangeModuleSettingString(): void
    {
        $name = new ID('stringSetting');
        $value = 'default';

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveString')
            ->with($name->val(), $value, 'awesomeModule');

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $moduleRepository->saveStringSetting($name, $value, 'awesomeModule');
    }

    public function testChangeModuleSettingCollection(): void
    {
        $name = new ID('boolSetting');
        $value = [3, 'interesting', 'values'];

        $moduleSettingService = $this->getModuleSettingServiceMock();
        $moduleSettingService->expects($this->once())
            ->method('saveCollection')
            ->with($name->val(), $value, 'awesomeModule');

        $moduleRepository = $this->getModuleSettingRepository(
            $moduleSettingService,
            $this->getModuleConfigurationDaoMock()
        );

        $moduleRepository->saveCollectionSetting($name, $value, 'awesomeModule');
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
        $moduleConfigurationDao = $this->getModuleConfigurationDaoMock();
        $moduleConfigurationDao->expects($this->once())
            ->method('get')
            ->willReturn($moduleConfiguration);

        $moduleRepository = $this->getModuleSettingRepository(
            $this->getModuleSettingServiceMock(),
            $moduleConfigurationDao
        );
        $settingsList = $moduleRepository->getSettingsList('awesomeModule');
        $this->assertEquals([$intSetting, $stringSetting, $arraySetting], $settingsList);
    }

    /**
     * @return ModuleConfigurationDaoInterface|(ModuleConfigurationDaoInterface&MockObject)|MockObject
     */
    public function getModuleConfigurationDaoMock(): ModuleConfigurationDaoInterface|MockObject
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

    /**
     * @return ModuleSettingRepository
     */
    public function getModuleSettingRepository(
        ModuleSettingServiceInterface $moduleSettingService,
        ModuleConfigurationDaoInterface|MockObject $moduleConfigurationDao
    ): ModuleSettingRepository {
        $basicContext = $this->createMock(BasicContextInterface::class);
        return new ModuleSettingRepository($moduleSettingService, $moduleConfigurationDao, $basicContext);
    }
}
