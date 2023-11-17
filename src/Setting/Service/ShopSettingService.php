<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use TheCodingMachine\GraphQLite\Types\ID;

final class ShopSettingService implements ShopSettingServiceInterface
{
    public function __construct(
        private ShopSettingRepositoryInterface $shopSettingRepository,
        private JsonServiceInterface $jsonService,
    ) {
    }

    public function getIntegerSetting(string $name): IntegerSetting
    {
        $integer = $this->shopSettingRepository->getInteger($name);
        return new IntegerSetting(new ID($name), $integer);
    }

    public function getFloatSetting(string $name): FloatSetting
    {
        $float = $this->shopSettingRepository->getFloat($name);
        return new FloatSetting(new ID($name), $float);
    }

    public function getBooleanSetting(string $name): BooleanSetting
    {
        $bool = $this->shopSettingRepository->getBoolean($name);
        return new BooleanSetting(new ID($name), $bool);
    }

    public function getStringSetting(string $name): StringSetting
    {
        $string = $this->shopSettingRepository->getString($name);
        return new StringSetting(new ID($name), $string);
    }

    public function getSelectSetting(string $name): StringSetting
    {
        $select = $this->shopSettingRepository->getSelect($name);
        return new StringSetting(new ID($name), $select);
    }

    public function getCollectionSetting(string $name): StringSetting
    {
        $collectionString = $this->shopSettingRepository->getCollection($name);
        $collectionEncodingResult = $this->jsonService->jsonEncodeArray($collectionString);

        return new StringSetting(new ID($name), $collectionEncodingResult);
    }

    public function getAssocCollectionSetting(string $name): StringSetting
    {
        $assocCollectionString = $this->shopSettingRepository->getAssocCollection($name);
        $assocCollectionEncodingResult = $this->jsonService->jsonEncodeArray($assocCollectionString);

        return new StringSetting(new ID($name), $assocCollectionEncodingResult);
    }

    /**
     * @return SettingType[]
     */
    public function getSettingsList(): array
    {
        $settingsList = $this->shopSettingRepository->getSettingsList();
        $settingsTypeList = [];
        foreach ($settingsList as $name => $type) {
            $settingsTypeList[] = new SettingType(new ID($name), $type);
        }

        return $settingsTypeList;
    }
}
