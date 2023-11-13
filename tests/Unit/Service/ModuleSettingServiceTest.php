<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;
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
        $serviceBooleanSetting = $this->getNegativeBooleanSetting();

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

    public function testChangeModuleSettingInteger(): void
    {
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('intSetting');
        $integerSetting = $settingService->changeIntegerSetting($nameID, 123, 'awesomeModule');

        $this->assertSame($nameID, $integerSetting->getName());
        $this->assertSame(123, $integerSetting->getValue());
    }

    public function testChangeModuleSettingFloat(): void
    {
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->changeFloatSetting($nameID, 1.23, 'awesomeModule');

        $this->assertSame($nameID, $floatSetting->getName());
        $this->assertSame(1.23, $floatSetting->getValue());
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('boolSetting');
        $value = false;
        $booleanSetting = $settingService->changeBooleanSetting($nameID, $value, 'awesomeModule');

        $this->assertSame($nameID, $booleanSetting->getName());
        $this->assertSame($value, $booleanSetting->getValue());
    }

    public function testChangeModuleSettingString(): void
    {
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);

        $settingService = new ModuleSettingService($repository);

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
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);

        $settingService = new ModuleSettingService($repository);

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
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);

        $settingService = new ModuleSettingService($repository);

        $nameID = new ID('collectionSetting');
        $value = '[2, "values"]';
        $collectionSetting = $settingService->changeCollectionSetting($nameID, $value, 'awesomeModule');

        $this->assertSame($nameID, $collectionSetting->getName());
        $this->assertSame($value, $collectionSetting->getValue());
    }

    public function testListModuleSettings(): void
    {
        $moduleId = 'awesomeModule';

        $intSetting = (new Setting())->setName('intSetting')->setType(FieldType::NUMBER);
        $stringSetting = (new Setting())->setName('stringSetting')->setType(FieldType::STRING);
        $arraySetting = (new Setting())->setName('arraySetting')->setType(FieldType::ARRAY);

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSettingsList')
            ->with($moduleId)
            ->willReturn([$intSetting, $stringSetting, $arraySetting]);

        $sut = new ModuleSettingService($repository);
        $this->assertEquals($this->getSettingTypeList(), $sut->getSettingsList($moduleId));
    }
}
