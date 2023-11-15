<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ShopSettingServiceTest extends UnitTestCase
{
    public function testGetShopSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getInteger')
            ->willReturn(123);

        $settingService = $this->getSut(shopSettingRepository: $repository);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getIntegerSetting($nameID);

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetShopSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $settingService = $this->getSut(shopSettingRepository: $repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getFloatSetting($nameID);

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetShopSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativeBooleanSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBoolean')
            ->willReturn(false);

        $settingService = $this->getSut(shopSettingRepository: $repository);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingService->getBooleanSetting($nameID);

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetShopSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getString')
            ->willReturn('default');

        $settingService = $this->getSut(shopSettingRepository: $repository);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingService->getStringSetting($nameID);

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetShopSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $repository = $this->createMock(ShopSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSelect')
            ->willReturn('select');

        $settingService = $this->getSut(shopSettingRepository: $repository);

        $nameID = new ID('selectSetting');
        $selectSetting = $settingService->getSelectSetting($nameID);

        $this->assertEquals($serviceSelectSetting, $selectSetting);
    }

    public function testGetShopSettingCollection(): void
    {
        $nameID = new ID('arraySetting');

        $repositoryResult = ['nice', 'values'];
        $collectionEncodingResult = 'someEncodedResult';
        $settingService = $this->getSut(
            shopSettingRepository: $this->getRepositorySettingGetterMock(
                'getCollection',
                $nameID,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult),
        );

        $this->assertEquals(
            new StringSetting($nameID, $collectionEncodingResult),
            $settingService->getCollectionSetting($nameID)
        );
    }

    public function testGetShopSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');
        $repositoryResult = ['first' => '10', 'second' => '20', 'third' => '50'];

        $collectionEncodingResult = 'someEncodedResult';
        $settingService = $this->getSut(
            shopSettingRepository: $this->getRepositorySettingGetterMock(
                'getAssocCollection',
                $nameID,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult),
        );

        $this->assertEquals(
            new StringSetting(new ID('aarraySetting'), $collectionEncodingResult),
            $settingService->getAssocCollectionSetting($nameID)
        );
    }

    private function getRepositorySettingGetterMock(
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
