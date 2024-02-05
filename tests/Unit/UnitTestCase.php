<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\CollectionEncodingServiceInterface;
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

    protected function getContextMock(int $shopId = 1): ContextInterface
    {
        $context = $this->createMock(ContextInterface::class);
        $context->method('getCurrentShopId')->willReturn($shopId);

        return $context;
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
