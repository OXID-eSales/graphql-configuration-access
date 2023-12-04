<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class UnitTestCase extends TestCase
{
    /**
     * @return SettingType[]
     */
    protected function getSettingTypeList(): array
    {
        $intSetting = new SettingType('intSetting', FieldType::NUMBER);
        $stringSetting = new SettingType('stringSetting', FieldType::STRING);
        $arraySetting = new SettingType('arraySetting', FieldType::ARRAY);
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
