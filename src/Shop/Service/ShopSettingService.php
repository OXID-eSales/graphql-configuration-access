<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shop\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\CollectionEncodingServiceInterface;

final class ShopSettingService implements ShopSettingServiceInterface
{
    public function __construct(
        private ShopSettingRepositoryInterface $shopSettingRepository,
        private CollectionEncodingServiceInterface $jsonService,
    ) {
    }

    public function getIntegerSetting(string $name): IntegerSetting
    {
        $integer = $this->shopSettingRepository->getInteger($name);
        return new IntegerSetting($name, $integer);
    }

    public function getFloatSetting(string $name): FloatSetting
    {
        $float = $this->shopSettingRepository->getFloat($name);
        return new FloatSetting($name, $float);
    }

    public function getBooleanSetting(string $name): BooleanSetting
    {
        $bool = $this->shopSettingRepository->getBoolean($name);
        return new BooleanSetting($name, $bool);
    }

    public function getStringSetting(string $name): StringSetting
    {
        $string = $this->shopSettingRepository->getString($name);
        return new StringSetting($name, $string);
    }

    public function getSelectSetting(string $name): StringSetting
    {
        $select = $this->shopSettingRepository->getSelect($name);
        return new StringSetting($name, $select);
    }

    public function getCollectionSetting(string $name): StringSetting
    {
        $collectionString = $this->shopSettingRepository->getCollection($name);
        $collectionEncodingResult = $this->jsonService->encodeArrayToString($collectionString);

        return new StringSetting($name, $collectionEncodingResult);
    }

    public function getAssocCollectionSetting(string $name): StringSetting
    {
        $assocCollectionString = $this->shopSettingRepository->getAssocCollection($name);
        $assocCollectionEncodingResult = $this->jsonService->encodeArrayToString($assocCollectionString);

        return new StringSetting($name, $assocCollectionEncodingResult);
    }

    /**
     * @return SettingType[]
     */
    public function getSettingsList(): array
    {
        $settingsList = $this->shopSettingRepository->getSettingsList();
        $settingsTypeList = [];
        foreach ($settingsList as $name => $type) {
            $settingsTypeList[] = new SettingType($name, $type);
        }

        return $settingsTypeList;
    }

    public function changeIntegerSetting(string $name, int $value): IntegerSetting
    {
        $this->shopSettingRepository->saveIntegerSetting($name, $value);

        return $this->getIntegerSetting($name);
    }

    public function changeFloatSetting(string $name, float $value): FloatSetting
    {
        $this->shopSettingRepository->saveFloatSetting($name, $value);

        return $this->getFloatSetting($name);
    }

    public function changeBooleanSetting(string $name, bool $value): BooleanSetting
    {
        $this->shopSettingRepository->saveBooleanSetting($name, $value);

        return $this->getBooleanSetting($name);
    }

    public function changeStringSetting(string $name, string $value): StringSetting
    {
        $this->shopSettingRepository->saveStringSetting($name, $value);

        return $this->getStringSetting($name);
    }

    public function changeSelectSetting(string $name, string $value): StringSetting
    {
        $this->shopSettingRepository->saveSelectSetting($name, $value);

        return $this->getSelectSetting($name);
    }

    public function changeCollectionSetting(string $name, string $value): StringSetting
    {
        $this->shopSettingRepository->saveCollectionSetting(
            $name,
            $this->jsonService->decodeStringCollectionToArray($value)
        );

        return $this->getCollectionSetting($name);
    }

    public function changeAssocCollectionSetting(string $name, string $value): StringSetting
    {
        $this->shopSettingRepository->saveAssocCollectionSetting(
            $name,
            $this->jsonService->decodeStringCollectionToArray($value)
        );

        return $this->getAssocCollectionSetting($name);
    }
}
