<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\CollectionEncodingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use PHPUnit\Framework\TestCase;

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
    ): CollectionEncodingServiceInterface {
        $jsonService = $this->createMock(CollectionEncodingServiceInterface::class);
        $jsonService->method('encodeArrayToString')
            ->with($repositoryResult)
            ->willReturn($collectionEncodingResult);
        return $jsonService;
    }
}
