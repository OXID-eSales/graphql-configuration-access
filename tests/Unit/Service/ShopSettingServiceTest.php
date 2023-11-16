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
    public function testGetShopSettingInteger(): void
    {
        $nameID = new ID('integerSetting');
        $repositoryResult = 123;

        $sut = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                'getInteger',
                $nameID,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new IntegerSetting($nameID, $repositoryResult),
            $sut->getIntegerSetting((string)$nameID)
        );
    }

    public function testGetShopSettingFloat(): void
    {
        $nameID = new ID('floatSetting');
        $repositoryResult = 1.23;

        $sut = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                'getFloat',
                $nameID,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new FloatSetting($nameID, $repositoryResult),
            $sut->getFloatSetting($nameID)
        );
    }

    public function testGetShopSettingBoolean(): void
    {
        $nameID = new ID('booleanSetting');
        $repositoryResult = false;

        $settingService = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                'getBoolean',
                $nameID,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new BooleanSetting($nameID, $repositoryResult),
            $settingService->getBooleanSetting($nameID)
        );
    }

    public function testGetShopSettingString(): void
    {
        $nameID = new ID('stringSetting');
        $repositoryResult = 'default';

        $settingService = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                'getString',
                $nameID,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new StringSetting($nameID, $repositoryResult),
            $settingService->getStringSetting($nameID)
        );
    }

    public function testGetShopSettingSelect(): void
    {
        $nameID = new ID('selectSetting');
        $repositoryResult = 'select';

        $settingService = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                'getSelect',
                $nameID,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new StringSetting($nameID, $repositoryResult),
            $settingService->getSelectSetting($nameID)
        );
    }

    public function testGetShopSettingCollection(): void
    {
        $nameID = new ID('arraySetting');
        $repositoryResult = ['nice', 'values'];
        $collectionEncodingResult = 'someEncodedResult';

        $settingService = $this->getSut(
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
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
            shopSettingRepository: $this->getShopRepositorySettingGetterMock(
                'getAssocCollection',
                $nameID,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult),
        );

        $this->assertEquals(
            new StringSetting($nameID, $collectionEncodingResult),
            $settingService->getAssocCollectionSetting($nameID)
        );
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
