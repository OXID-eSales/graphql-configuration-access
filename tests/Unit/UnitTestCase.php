<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class UnitTestCase extends TestCase
{
    protected function getIntegerSetting(): IntegerSetting
    {
        return new IntegerSetting(new ID('integerSetting'), 123);
    }

    protected function getFloatSetting(): FloatSetting
    {
        return new FloatSetting(new ID('floatSetting'), 1.23);
    }

    protected function getNegativeBooleanSetting(): BooleanSetting
    {
        return new BooleanSetting(new ID('booleanSetting'), false);
    }

    protected function getPositiveBooleanSetting(): BooleanSetting
    {
        return new BooleanSetting(new ID('booleanSetting'), true);
    }

    protected function getStringSetting(): StringSetting
    {
        return new StringSetting(new ID('stringSetting'), 'default');
    }

    protected function getSelectSetting(): StringSetting
    {
        return new StringSetting(new ID('selectSetting'), 'select');
    }

    protected function getCollectionSetting(): StringSetting
    {
        return new StringSetting(new ID('arraySetting'), json_encode(['nice', 'values']));
    }

    protected function getAssocCollectionSetting(): StringSetting
    {
        return new StringSetting(
            new ID('aarraySetting'),
            json_encode(
                [
                    'first' => '10',
                    'second' => '20',
                    'third' => '50'
                ]
            )
        );
    }

    protected function getSettingType(): SettingType
    {
        return new SettingType(new ID('settingType'), FieldType::BOOLEAN);
    }

    /**
     * @return SettingType[]
     */
    protected function getSettingTypeList(): array
    {
        $intSetting = new SettingType(new ID('intSetting'), FieldType::NUMBER);
        $stringSetting = new SettingType(new ID('stringSetting'), FieldType::STRING);
        $arraySetting = new SettingType(new ID('arraySetting'), FieldType::ARRAY);
        return [$intSetting, $stringSetting, $arraySetting];
    }

    protected function getBasicContextMock(int $shopId = 1): BasicContextInterface
    {
        $basicContext = $this->createMock(BasicContextInterface::class);
        $basicContext->method('getCurrentShopId')->willReturn($shopId);

        return $basicContext;
    }

    protected function getJsonEncodeServiceMock(
        array $repositoryResult,
        string $collectionEncodingResult
    ): JsonServiceInterface {
        $jsonService = $this->createMock(JsonServiceInterface::class);
        $jsonService->method('jsonEncodeArray')
            ->with($repositoryResult)
            ->willReturn($collectionEncodingResult);
        return $jsonService;
    }
}
