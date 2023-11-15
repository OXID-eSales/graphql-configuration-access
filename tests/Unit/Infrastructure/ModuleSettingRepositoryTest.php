<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use Symfony\Component\String\UnicodeString;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingRepositoryTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $name = 'integerSetting';
        $moduleId = 'awesomeModule';

        $shopServiceReturn = 123;
        $moduleRepository = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMock(
                'getInteger',
                $name,
                $moduleId,
                $shopServiceReturn
            )
        );

        $this->assertEquals(
            $shopServiceReturn,
            $moduleRepository->getIntegerSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingFloat(): void
    {
        $name = 'floatSetting';
        $shopServiceReturn = 1.23;
        $moduleId = 'awesomeModule';

        $moduleRepository = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMock(
                'getFloat',
                $name,
                $moduleId,
                $shopServiceReturn
            ),
        );

        $this->assertEquals(
            $shopServiceReturn,
            $moduleRepository->getFloatSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingBoolean(): void
    {
        $name = 'booleanSetting';
        $shopServiceReturn = false;
        $moduleId = 'awesomeModule';

        $moduleRepository = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMock(
                'getBoolean',
                $name,
                $moduleId,
                $shopServiceReturn
            ),
        );

        $this->assertEquals(
            $shopServiceReturn,
            $moduleRepository->getBooleanSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingString(): void
    {
        $name = 'stringSetting';
        $moduleId = 'awesomeModule';
        $repositoryReturn = 'default';

        $moduleRepository = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMock(
                'getString',
                $name,
                $moduleId,
                new UnicodeString($repositoryReturn)
            ),
        );

        $this->assertEquals(
            $repositoryReturn,
            $moduleRepository->getStringSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingCollection(): void
    {
        $name = 'arraySetting';
        $moduleId = 'awesomeModule';
        $repositoryReturn = ['nice', 'values'];

        $moduleRepository = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMock(
                'getCollection',
                $name,
                $moduleId,
                $repositoryReturn
            ),
        );

        $this->assertEquals(
            $repositoryReturn,
            $moduleRepository->getCollectionSetting($name, $moduleId)
        );
    }

    public function testChangeModuleSettingInteger(): void
    {
        $name = new ID('intSetting');

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveInteger')
            ->with($name->val(), 123, 'awesomeModule');

        $moduleRepository = $this->getSut(
            $moduleSettingService,
            $this->createMock(ModuleConfigurationDaoInterface::class)
        );

        $moduleRepository->saveIntegerSetting($name, 123, 'awesomeModule');
    }

    public function testChangeModuleSettingFloat(): void
    {
        $name = new ID('floatSetting');

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveFloat')
            ->with($name->val(), 1.23, 'awesomeModule');

        $moduleRepository = $this->getSut(
            $moduleSettingService,
            $this->createMock(ModuleConfigurationDaoInterface::class)
        );

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

        $moduleRepository = $this->getSut(
            $moduleSettingService,
            $this->createMock(ModuleConfigurationDaoInterface::class)
        );

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

        $moduleRepository = $this->getSut(
            $moduleSettingService,
            $this->createMock(ModuleConfigurationDaoInterface::class)
        );

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

        $moduleRepository = $this->getSut(
            $moduleSettingService,
            $this->createMock(ModuleConfigurationDaoInterface::class)
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
        $moduleConfigurationDao = $this->createMock(ModuleConfigurationDaoInterface::class);
        $moduleConfigurationDao->expects($this->once())
            ->method('get')
            ->willReturn($moduleConfiguration);

        $moduleRepository = $this->getSut(
            $this->createMock(ModuleSettingServiceInterface::class),
            $moduleConfigurationDao
        );
        $settingsList = $moduleRepository->getSettingsList('awesomeModule');
        $this->assertEquals([$intSetting, $stringSetting, $arraySetting], $settingsList);
    }

    public function getSut(
        ?ModuleSettingServiceInterface $moduleSettingService = null,
        ?ModuleConfigurationDaoInterface $moduleConfigurationDao = null,
        ?BasicContextInterface $basicContext = null,
    ): ModuleSettingRepository {
        $moduleConfigurationDao = $moduleConfigurationDao ?? $this->createStub(ModuleConfigurationDaoInterface::class);

        return new ModuleSettingRepository(
            moduleSettingService: $moduleSettingService ?? $this->createStub(ModuleSettingServiceInterface::class),
            moduleConfigurationDao: $moduleConfigurationDao,
            basicContext: $basicContext ?? $this->createStub(BasicContextInterface::class)
        );
    }

    private function getShopModuleSettingServiceMock(
        string $methodName,
        string $name,
        string $moduleId,
        $shopServiceReturn
    ): ModuleSettingServiceInterface {
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method($methodName)
            ->with($name, $moduleId)
            ->willReturn($shopServiceReturn);
        return $moduleSettingService;
    }
}
