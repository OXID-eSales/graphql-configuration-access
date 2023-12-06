<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\InvalidCollectionException;

final class ThemeSettingService implements ThemeSettingServiceInterface
{
    public function __construct(
        private ThemeSettingRepositoryInterface $themeSettingRepository,
        private CollectionEncodingServiceInterface $jsonService,
    ) {
    }

    public function getIntegerSetting(string $name, string $themeId): IntegerSetting
    {
        $integer = $this->themeSettingRepository->getInteger($name, $themeId);
        return new IntegerSetting($name, $integer);
    }

    public function getFloatSetting(string $name, string $themeId): FloatSetting
    {
        $float = $this->themeSettingRepository->getFloat($name, $themeId);
        return new FloatSetting($name, $float);
    }

    public function getBooleanSetting(string $name, string $themeId): BooleanSetting
    {
        $bool = $this->themeSettingRepository->getBoolean($name, $themeId);
        return new BooleanSetting($name, $bool);
    }

    public function getStringSetting(string $name, string $themeId): StringSetting
    {
        $string = $this->themeSettingRepository->getString($name, $themeId);
        return new StringSetting($name, $string);
    }

    public function getSelectSetting(string $name, string $themeId): StringSetting
    {
        $select = $this->themeSettingRepository->getSelect($name, $themeId);
        return new StringSetting($name, $select);
    }

    public function getCollectionSetting(string $name, string $themeId): StringSetting
    {
        $collection = $this->themeSettingRepository->getCollection($name, $themeId);
        $collectionEncodingResult = $this->jsonService->encodeArrayToString($collection);

        return new StringSetting($name, $collectionEncodingResult);
    }

    public function getAssocCollectionSetting(string $name, string $themeId): StringSetting
    {
        $assocCollection = $this->themeSettingRepository->getAssocCollection($name, $themeId);
        $collectionEncodingResult = $this->jsonService->encodeArrayToString($assocCollection);

        return new StringSetting($name, $collectionEncodingResult);
    }

    /**
     * @return SettingType[]
     */
    public function getSettingsList(string $themeId): array
    {
        $settingsList = $this->themeSettingRepository->getSettingsList($themeId);
        $settingsTypeList = [];
        foreach ($settingsList as $name => $type) {
            $settingsTypeList[] = new SettingType($name, $type);
        }

        return $settingsTypeList;
    }

    public function changeIntegerSetting(string $name, int $value, string $themeId): IntegerSetting
    {
        $this->themeSettingRepository->saveIntegerSetting($name, $value, $themeId);

        return $this->getIntegerSetting($name, $themeId);
    }

    public function changeFloatSetting(string $name, float $value, string $themeId): FloatSetting
    {
        $this->themeSettingRepository->saveFloatSetting($name, $value, $themeId);
        return $this->getFloatSetting($name, $themeId);
    }

    public function changeBooleanSetting(string $name, bool $value, string $themeId): BooleanSetting
    {
        $this->themeSettingRepository->saveBooleanSetting($name, $value, $themeId);

        return $this->getBooleanSetting($name, $themeId);
    }

    public function changeStringSetting(string $name, string $value, string $themeId): StringSetting
    {
        $this->themeSettingRepository->saveStringSetting($name, $value, $themeId);

        return $this->getStringSetting($name, $themeId);
    }

    public function changeSelectSetting(string $name, string $value, string $themeId): StringSetting
    {
        $this->themeSettingRepository->saveSelectSetting($name, $value, $themeId);

        return $this->getSelectSetting($name, $themeId);
    }

    public function changeCollectionSetting(string $name, string $value, string $themeId): StringSetting
    {
        $arrayValue = json_decode($value, false);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollectionException($value);
        }

        $this->themeSettingRepository->saveCollectionSetting($name, $arrayValue, $themeId);

        return $this->getCollectionSetting($name, $themeId);
    }

    public function changeAssocCollectionSetting(string $name, string $value, string $themeId): StringSetting
    {
        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollectionException($value);
        }

        $this->themeSettingRepository->saveAssocCollectionSetting($name, $arrayValue, $themeId);

        return $this->getAssocCollectionSetting($name, $themeId);
    }
}
