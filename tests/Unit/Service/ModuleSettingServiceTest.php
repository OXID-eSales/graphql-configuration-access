<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ModuleSettingServiceTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();
        $settingService = $this->getModuleSettingServiceMock('num','getIntegerSetting', $serviceIntegerSetting);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getIntegerSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

    public function testGetModuleSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();
        $settingService = $this->getModuleSettingServiceMock('num','getFloatSetting', $serviceFloatSetting);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getFloatSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceFloatSetting, $floatSetting);
    }

    public function testGetModuleSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getBooleanSetting();
        $settingService = $this->getModuleSettingServiceMock('bool','getBooleanSetting', $serviceBooleanSetting);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingService->getBooleanSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetModuleSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();
        $settingService = $this->getModuleSettingServiceMock('str','getStringSetting', $serviceStringSetting);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingService->getStringSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceStringSetting, $stringSetting);
    }

    public function testGetModuleSettingCollection(): void
    {
        $serviceCollectionSetting = $this->getCollectionSetting();
        $settingService = $this->getModuleSettingServiceMock('arr','getCollectionSetting', $serviceCollectionSetting);

        $nameID = new ID('arraySetting');
        $collectionSetting = $settingService->getCollectionSetting($nameID, 'awesomeModule');

        $this->assertSame($serviceCollectionSetting, $collectionSetting);
    }

    public function testChangeModuleSettingInteger(): void
    {
        $settingService = $this->getModuleSettingServiceMock('num',);

        $nameID = new ID('intSetting');
        $integerSetting = $settingService->changeIntegerSetting($nameID, 123, 'awesomeModule');

        $this->assertSame($nameID, $integerSetting->getName());
        $this->assertSame(123, $integerSetting->getValue());
    }

    public function testChangeModuleSettingFloat(): void
    {
        $settingService = $this->getModuleSettingServiceMock('num',);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->changeFloatSetting($nameID, 1.23, 'awesomeModule');

        $this->assertSame($nameID, $floatSetting->getName());
        $this->assertSame(1.23, $floatSetting->getValue());
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $settingService = $this->getModuleSettingServiceMock('bool',);

        $nameID = new ID('boolSetting');
        $value = false;
        $booleanSetting = $settingService->changeBooleanSetting($nameID, $value, 'awesomeModule');

        $this->assertSame($nameID, $booleanSetting->getName());
        $this->assertSame($value, $booleanSetting->getValue());
    }

    public function testChangeModuleSettingString(): void
    {
        $settingService = $this->getModuleSettingServiceMock('str',);

        $nameID = new ID('stringSetting');
        $value = 'default';
        $stringSetting = $settingService->changeStringSetting($nameID, $value, 'awesomeModule');

        $this->assertSame($nameID, $stringSetting->getName());
        $this->assertSame($value, $stringSetting->getValue());
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     */
    public function testChangeModuleSettingInvalidCollection($value): void
    {
        $settingService = $this->getModuleSettingServiceMock('arr',);

        $nameID = new ID('collectionSetting');

        $this->expectException(InvalidCollection::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid collection string.', $value));

        $settingService->changeCollectionSetting($nameID, $value, 'awesomeModule');
    }

    public function invalidCollectionDataProvider(): array
    {
        return [
            ['[2, "values"'],
            ['{2, "values"}'],
            ['2, "values"}'],
            ['[2, values]'],
            ['"3, interesting, values"'],
            ['"3, \'interesting\', \'values\'"'],
        ];
    }

    public function testChangeModuleSettingCollection(): void
    {
        $settingService = $this->getModuleSettingServiceMock('arr',);

        $nameID = new ID('collectionSetting');
        $value = '[2, "values"]';
        $collectionSetting = $settingService->changeCollectionSetting($nameID, $value, 'awesomeModule');

        $this->assertSame($nameID, $collectionSetting->getName());
        $this->assertSame($value, $collectionSetting->getValue());
    }

    /**
     * @dataProvider invalidSettingTypeDataProvider
     */
    public function testChangeModuleSettingInvalidSettingType($method, $setting, $value, $type): void
    {
        $settingService = $this->getModuleSettingServiceMock($type);

        $nameID = new ID($setting);

        $this->expectException(InvalidType::class);
        $this->expectExceptionMessage((new InvalidType($type))->getMessage());

        $settingService->$method($nameID, $value, 'awesomeModule');
    }

    public function invalidSettingTypeDataProvider(): array
    {
        return [
            ['changeStringSetting', 'intSetting', '123', 'num'],
            ['changeStringSetting', 'arraySetting', '[2, "values"]', 'arr'],
            ['changeIntegerSetting', 'stringSetting', 123, 'str'],
            ['changeFloatSetting', 'stringSetting', 123, 'str'],
            ['changeBooleanSetting', 'intSetting', 1, 'num'],
        ];
    }

    private function getModuleSettingServiceMock(string $type, string $method = null, mixed $returnValue = null): ModuleSettingService
    {
        $context = $this->getMockBuilder(ContextInterface::class)->getMock();
        $context
            ->method('getCurrentShopId')
            ->willReturn(1);

        $setting = $this->getMockBuilder(Setting::class)->getMock();
        $setting
            ->method('getType')
            ->willReturn($type);

        $moduleConfiguration = $this->getMockBuilder(ModuleConfiguration::class)->getMock();
        $moduleConfiguration
            ->method('getModuleSetting')
            ->willReturn($setting);

        $moduleConfigurationDao = $this->getMockBuilder(ModuleConfigurationDaoInterface::class)->getMock();
        $moduleConfigurationDao
            ->method('get')
            ->with('awesomeModule', 1)
            ->willReturn($moduleConfiguration);


        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        if ($method) {
            $repository
                ->expects($this->once())
                ->method($method)
                ->willReturn($returnValue);
        }

        return new ModuleSettingService($context, $moduleConfigurationDao, $repository);
    }
}
