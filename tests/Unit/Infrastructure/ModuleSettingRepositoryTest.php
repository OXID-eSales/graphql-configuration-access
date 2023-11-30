<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use Symfony\Component\String\UnicodeString;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository
 */
class ModuleSettingRepositoryTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $name = 'integerSetting';
        $moduleId = 'awesomeModule';

        $shopServiceReturn = 123;
        $moduleRepository = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
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
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
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
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
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
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
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
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
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

    public function testSaveIntegerSettingProxyingDataToShopService(): void
    {
        $name = 'intSetting';
        $moduleId = 'awesomeModule';

        $callValue = 123;
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveInteger')
            ->with($name, $callValue, $moduleId);

        $moduleRepository = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $moduleRepository->saveIntegerSetting($name, $callValue, $moduleId);
    }

    public function testSaveFloatSettingProxyingDataToShopService(): void
    {
        $name = 'floatSetting';
        $moduleId = 'awesomeModule';

        $callValue = 1.23;
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveFloat')
            ->with($name, $callValue, $moduleId);

        $moduleRepository = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $moduleRepository->saveFloatSetting($name, $callValue, $moduleId);
    }

    public function testSaveBooleanSettingProxyingDataToShopService(): void
    {
        $name = 'boolSetting';
        $moduleId = 'awesomeModule';

        $callValue = false;
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveBoolean')
            ->with($name, $callValue, $moduleId);

        $moduleRepository = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $moduleRepository->saveBooleanSetting($name, $callValue, $moduleId);
    }

    public function testSaveStringSettingProxyingDataToShopService(): void
    {
        $name = 'stringSetting';
        $moduleId = 'awesomeModule';

        $callValue = 'default';
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveString')
            ->with($name, $callValue, $moduleId);

        $moduleRepository = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $moduleRepository->saveStringSetting($name, $callValue, $moduleId);
    }

    public function testSaveCollectionSettingProxyingDataToShopService(): void
    {
        $name = 'collectionSetting';
        $moduleId = 'awesomeModule';

        $callValue = [3, 'interesting', 'values'];
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveCollection')
            ->with($name, $callValue, $moduleId);

        $moduleRepository = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $moduleRepository->saveCollectionSetting($name, $callValue, $moduleId);
    }

    public function testGetSettingsList(): void
    {
        $shopId = 3;
        $moduleId = 'awesomeModule';

        $response = [
            $this->createStub(Setting::class),
            $this->createStub(Setting::class),
        ];

        $moduleConfigurationDao = $this->createMock(ModuleConfigurationDaoInterface::class);
        $moduleConfigurationDao->expects($this->once())
            ->method('get')
            ->with($moduleId, $shopId)
            ->willReturn(
                $this->createConfiguredMock(ModuleConfiguration::class, [
                    'getModuleSettings' => $response
                ])
            );

        $moduleRepository = $this->getSut(
            moduleConfigurationDao: $moduleConfigurationDao,
            basicContext: $this->getBasicContextMock($shopId),
        );

        $this->assertSame(
            $response,
            $moduleRepository->getSettingsList($moduleId)
        );
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

    private function getShopModuleSettingServiceMethodStub(
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
