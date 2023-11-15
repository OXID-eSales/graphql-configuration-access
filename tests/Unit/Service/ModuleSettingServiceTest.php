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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
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

        $sut = $this->getSut($repository);

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

        $sut = $this->getSut($repository);

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

        $sut = $this->getSut($repository);

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

        $sut = $this->getSut($repository);

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

        $encoderResponse = 'encoderResponse';
        $encoder = $this->createMock(JsonServiceInterface::class);
        $encoder->method('jsonEncodeArray')
            ->with($repositoryResponse)
            ->willReturn($encoderResponse);

        $sut = $this->getSut(
            repository: $repository,
            jsonService: $encoder
        );

        $nameID = new ID($name);
        $this->assertEquals(
            new StringSetting($nameID, $encoderResponse),
            $sut->getCollectionSetting($nameID, $moduleId)
        );
    }

    public function testChangeModuleSettingInteger(): void
    {
        $name = 'intSetting';
        $moduleId = 'awesomeModule';

        $callValue = 123;
        $repositoryValue = 321;

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveIntegerSetting')
            ->with($name, $callValue, $moduleId);
        $repository->expects($this->once())
            ->method('getIntegerSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            repository: $repository
        );

        $nameID = new ID($name);
        $setting = $sut->changeIntegerSetting($nameID, $callValue, $moduleId);

        $this->assertSame($nameID, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingFloat(): void
    {
        $name = 'floatSetting';
        $moduleId = 'awesomeModule';

        $callValue = 1.23;
        $repositoryValue = 3.21;

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveFloatSetting')
            ->with($name, $callValue, $moduleId);
        $repository->expects($this->once())
            ->method('getFloatSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            repository: $repository
        );

        $nameID = new ID($name);
        $setting = $sut->changeFloatSetting($nameID, $callValue, $moduleId);

        $this->assertSame($nameID, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $name = 'boolSetting';
        $moduleId = 'awesomeModule';

        $callValue = true;
        $repositoryValue = false;

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveBooleanSetting')
            ->with($name, $callValue, $moduleId);
        $repository->expects($this->once())
            ->method('getBooleanSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            repository: $repository
        );

        $nameID = new ID($name);
        $setting = $sut->changeBooleanSetting($nameID, $callValue, $moduleId);

        $this->assertSame($nameID, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingString(): void
    {
        $name = 'stringSetting';
        $moduleId = 'awesomeModule';

        $callValue = 'someNewValue';
        $repositoryValue = 'realDatabaseValue';

        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveStringSetting')
            ->with($name, $callValue, $moduleId);
        $repository->expects($this->once())
            ->method('getStringSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            repository: $repository
        );

        $nameID = new ID($name);
        $setting = $sut->changeStringSetting($nameID, $callValue, $moduleId);

        $this->assertSame($nameID, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingCollection(): void
    {
        $name = 'collectionSetting';
        $moduleId = 'awesomeModule';

        $callValue = 'someCollectionValue';
        $repositoryValue = ['realDatabaseValue'];

        $decodedValue = ['decodedCollectionValue'];
        $repository = $this->createMock(ModuleSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveCollectionSetting')
            ->with($name, $decodedValue, $moduleId);
        $repository->method('getCollectionSetting')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $encoderResponse = 'encoderResponse';
        $encoder = $this->createMock(JsonServiceInterface::class);
        $encoder->method('jsonEncodeArray')
            ->with($repositoryValue)
            ->willReturn($encoderResponse);
        $encoder->method('jsonDecodeCollection')
            ->with($callValue)
            ->willReturn($decodedValue);

        $sut = $this->getSut(
            repository: $repository,
            jsonService: $encoder,
        );

        $nameID = new ID($name);
        $setting = $sut->changeCollectionSetting($nameID, $callValue, $moduleId);

        $this->assertSame($nameID, $setting->getName());
        $this->assertSame($encoderResponse, $setting->getValue());
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

        $sut = $this->getSut($repository);
        $this->assertEquals($this->getSettingTypeList(), $sut->getSettingsList($moduleId));
    }

    private function getSut(
        ?ModuleSettingRepositoryInterface $repository = null,
        ?JsonServiceInterface $jsonService = null,
    ): ModuleSettingService {
        return new ModuleSettingService(
            moduleSettingRepository: $repository ?? $this->createStub(ModuleSettingRepositoryInterface::class),
            jsonService: $jsonService ?? $this->createStub(JsonServiceInterface::class),
        );
    }
}
