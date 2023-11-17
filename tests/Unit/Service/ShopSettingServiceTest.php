<?php

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
