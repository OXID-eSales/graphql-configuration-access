<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingService
 */
class ShopSettingServiceTest extends UnitTestCase
{
    /** @dataProvider getNotEncodableShopSettingDataProvider */
    public function testGetNotEncodableShopSetting(
        string $repositoryMethod,
        mixed $repositoryResult,
        string $serviceMethod,
        mixed $expectedResult
    ): void {
        $nameID = new ID('settingName');

        $sut = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                $repositoryMethod,
                $nameID,
                $repositoryResult
            )
        );

        $this->assertEquals($expectedResult, $sut->$serviceMethod((string)$nameID));
    }

    public function getNotEncodableShopSettingDataProvider(): \Generator
    {
        $nameID = new ID('settingName');

        yield 'getIntegerSetting' => [
            'repositoryMethod' => 'getInteger',
            'repositoryResult' => 123,
            'serviceMethod' => 'getIntegerSetting',
            'expectedResult' => new IntegerSetting($nameID, 123)
        ];

        yield 'getFloatSetting' => [
            'repositoryMethod' => 'getFloat',
            'repositoryResult' => 1.23,
            'serviceMethod' => 'getFloatSetting',
            'expectedResult' => new FloatSetting($nameID, 1.23)
        ];

        yield 'getBooleanSetting' => [
            'repositoryMethod' => 'getBoolean',
            'repositoryResult' => false,
            'serviceMethod' => 'getBooleanSetting',
            'expectedResult' => new BooleanSetting($nameID, false)
        ];

        yield 'getStringSetting' => [
            'repositoryMethod' => 'getString',
            'repositoryResult' => 'default',
            'serviceMethod' => 'getStringSetting',
            'expectedResult' => new StringSetting($nameID, 'default')
        ];

        yield 'getSelectSetting' => [
            'repositoryMethod' => 'getSelect',
            'repositoryResult' => 'selectResult',
            'serviceMethod' => 'getSelectSetting',
            'expectedResult' => new StringSetting($nameID, 'selectResult')
        ];
    }

    /** @dataProvider getEncodableShopSettingDataProvider */
    public function testGetEncodableShopSetting(
        string $repositoryMethod,
        mixed $repositoryResult,
        string $serviceMethod
    ): void {
        $nameID = new ID('settingName');
        $encodingResult = 'someEncodedResult';

        $sut = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                $repositoryMethod,
                $nameID,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $encodingResult),
        );

        $this->assertEquals(
            new StringSetting($nameID, $encodingResult),
            $sut->$serviceMethod((string)$nameID)
        );
    }

    public function getEncodableShopSettingDataProvider(): \Generator
    {
        yield 'getCollectionSetting' => [
            'repositoryMethod' => 'getCollection',
            'repositoryResult' => ['nice', 'values'],
            'serviceMethod' => 'getCollectionSetting',
        ];

        yield 'getAssocCollectionSetting' => [
            'repositoryMethod' => 'getAssocCollection',
            'repositoryResult' => ['first' => '10', 'second' => '20', 'third' => '50'],
            'serviceMethod' => 'getAssocCollectionSetting',
        ];
    }

    private function getShopRepositorySettingGetterMock(
        string $repositoryMethod,
        ID $nameID,
        $repositoryResult
    ): ShopSettingRepositoryInterface {
        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method($repositoryMethod)
            ->with($nameID)
            ->willReturn($repositoryResult);
        return $repository;
    }

    public function testChangeShopSettingInteger(): void
    {
        $name = 'someSettingName';

        $callValue = 123;
        $repositoryValue = 321;

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getInteger')
            ->with($name)
            ->willReturn($repositoryValue);
        $repository->expects($this->once())
            ->method('saveIntegerSetting')
            ->with($name, $callValue);

        $sut = $this->getSut(
            shopSettingRepository: $repository
        );

        $setting = $sut->changeIntegerSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeShopSettingFloat(): void
    {
        $name = 'someSettingName';

        $callValue = 1.23;
        $repositoryValue = 3.21;

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloat')
            ->with($name)
            ->willReturn($repositoryValue);
        $repository->expects($this->once())
            ->method('saveFloatSetting')
            ->with($name, $callValue);

        $sut = $this->getSut(
            shopSettingRepository: $repository
        );

        $setting = $sut->changeFloatSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeShopSettingBoolean(): void
    {
        $name = 'someSettingName';

        $callValue = false;
        $repositoryValue = true;

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBoolean')
            ->with($name)
            ->willReturn($repositoryValue);
        $repository->expects($this->once())
            ->method('saveBooleanSetting')
            ->with($name, $callValue);

        $sut = $this->getSut(
            shopSettingRepository: $repository
        );

        $setting = $sut->changeBooleanSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeShopSettingString(): void
    {
        $name = 'someSettingName';

        $callValue = 'call example';
        $repositoryValue = 'response example';

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getString')
            ->with($name)
            ->willReturn($repositoryValue);
        $repository->expects($this->once())
            ->method('saveStringSetting')
            ->with($name, $callValue);

        $sut = $this->getSut(
            shopSettingRepository: $repository
        );

        $setting = $sut->changeStringSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeShopSettingSelect(): void
    {
        $name = 'someSettingName';

        $callValue = 'call select example';
        $repositoryValue = 'response select example';

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSelect')
            ->with($name)
            ->willReturn($repositoryValue);
        $repository->expects($this->once())
            ->method('saveSelectSetting')
            ->with($name, $callValue);

        $sut = $this->getSut(
            shopSettingRepository: $repository
        );

        $setting = $sut->changeSelectSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingCollection(): void
    {
        $name = 'someSettingName';

        $callValue = 'someCollectionValue';
        $repositoryValue = ['realDatabaseValue'];

        $decodedValue = ['decodedCollectionValue'];
        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveCollectionSetting')
            ->with($name, $decodedValue);
        $repository->method('getCollection')
            ->with($name)
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
            shopSettingRepository: $repository,
            jsonService: $encoder,
        );

        $setting = $sut->changeCollectionSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($encoderResponse, $setting->getValue());
    }

    public function testChangeModuleSettingAssocCollection(): void
    {
        $name = 'someSettingName';

        $callValue = 'someCollectionValue';
        $repositoryValue = ['someKey'=>'realDatabaseValue'];

        $decodedValue = ['someKey'=>'decodedCollectionValue'];
        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('saveAssocCollectionSetting')
            ->with($name, $decodedValue);
        $repository->method('getAssocCollection')
            ->with($name)
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
            shopSettingRepository: $repository,
            jsonService: $encoder,
        );

        $setting = $sut->changeAssocCollectionSetting($name, $callValue);

        $this->assertSame($name, (string)$setting->getName());
        $this->assertSame($encoderResponse, $setting->getValue());
    }

    public function testListShopSettings(): void
    {
        $repositorySettingsList = [
            'intSetting' => FieldType::NUMBER,
            'stringSetting' => FieldType::STRING,
            'arraySetting' => FieldType::ARRAY
        ];

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSettingsList')
            ->willReturn($repositorySettingsList);

        $sut = $this->getSut(shopSettingRepository: $repository);

        $this->assertEquals($this->getSettingTypeList(), $sut->getSettingsList());
    }

    private function getSut(
        ?ShopSettingRepositoryInterface $shopSettingRepository = null,
        ?JsonServiceInterface $jsonService = null,
    ): ShopSettingService {
        $shopSettingRepository = $shopSettingRepository ?? $this->createStub(ShopSettingRepositoryInterface::class);
        return new ShopSettingService(
            shopSettingRepository: $shopSettingRepository,
            jsonService: $jsonService ?? $this->createStub(JsonServiceInterface::class)
        );
    }
}
