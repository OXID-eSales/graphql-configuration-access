<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
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
        $name = 'integerSetting';
        $moduleId = 'awesomeModule';

        $repositoryResponse = 123;
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getIntegerSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryResponse);

        $sut = new ModuleSettingService($repository);

        $nameID = new ID($name);
        $this->assertEquals(
            new IntegerSetting($nameID, $repositoryResponse),
            $sut->getIntegerSetting($nameID, $moduleId)
        );
    }

    public function testGetModuleSettingFloat(): void
    {
        $name = 'floatSetting';
        $moduleId = 'awesomeModule';

        $repositoryResponse = 1.23;
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloatSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryResponse);

        $sut = new ModuleSettingService($repository);

        $nameID = new ID($name);
        $this->assertEquals(
            new FloatSetting($nameID, $repositoryResponse),
            $sut->getFloatSetting($nameID, $moduleId)
        );
    }

    public function testGetModuleSettingBoolean(): void
    {
        $name = 'booleanSetting';
        $moduleId = 'awesomeModule';

        $repositoryResponse = false;
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBooleanSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryResponse);

        $sut = new ModuleSettingService($repository);

        $nameID = new ID($name);
        $this->assertEquals(
            new BooleanSetting($nameID, $repositoryResponse),
            $sut->getBooleanSetting($nameID, $moduleId)
        );
    }

    public function testGetModuleSettingString(): void
    {
        $name = 'stringSetting';
        $moduleId = 'awesomeModule';

        $repositoryResponse = 'default';
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getStringSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryResponse);

        $sut = new ModuleSettingService($repository);

        $nameID = new ID($name);
        $this->assertEquals(
            new StringSetting($nameID, $repositoryResponse),
            $sut->getStringSetting($nameID, $moduleId)
        );
    }

    public function testGetModuleSettingCollection(): void
    {
        $name = 'arraySetting';
        $moduleId = 'awesomeModule';

        $repositoryResponse = ['nice', 'values'];
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getCollectionSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryResponse);

        $sut = new ModuleSettingService($repository);

        $nameID = new ID($name);
        $this->assertEquals(
            new StringSetting($nameID, json_encode($repositoryResponse)),
            $sut->getCollectionSetting($nameID, $moduleId)
        );
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
