<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingService implements ThemeSettingServiceInterface
{
    public function __construct(
        private ThemeSettingRepositoryInterface $themeSettingRepository
    ) {}

    public function getIntegerSetting(ID $name, string $themeId): IntegerSetting
    {
        $integer = $this->themeSettingRepository->getInteger($name, $themeId);
        return new IntegerSetting($name, $integer);
    }

    public function getFloatSetting(ID $name, string $themeId): FloatSetting
    {
        $float = $this->themeSettingRepository->getFloat($name, $themeId);
        return new FloatSetting($name, $float);
    }

    public function getBooleanSetting(ID $name, string $themeId): BooleanSetting
    {
        $bool = $this->themeSettingRepository->getBoolean($name, $themeId);
        return new BooleanSetting($name, $bool);
    }

    public function getStringSetting(ID $name, string $themeId): StringSetting
    {
        $string = $this->themeSettingRepository->getString($name, $themeId);
        return new StringSetting($name, $string);
    }

    public function getSelectSetting(ID $name, string $themeId): StringSetting
    {
        $select = $this->themeSettingRepository->getSelect($name, $themeId);
        return new StringSetting($name, $select);
    }

    public function getCollectionSetting(ID $name, string $themeId): StringSetting
    {
        $collectionString = $this->themeSettingRepository->getCollection($name, $themeId);
        return new StringSetting($name, json_encode($collectionString));
    }

    public function getAssocCollectionSetting(ID $name, string $themeId): StringSetting
    {
        $assocCollectionString = $this->themeSettingRepository->getAssocCollection($name, $themeId);
        return new StringSetting($name, json_encode($assocCollectionString));
    }

    public function changeIntegerSetting(ID $name, int $value, string $themeId): IntegerSetting
    {
        $this->themeSettingRepository->saveIntegerSetting($name, $value, $themeId);

        return new IntegerSetting($name, $value);
    }

    public function changeFloatSetting(ID $name, float $value, string $themeId): FloatSetting
    {
        $this->themeSettingRepository->saveFloatSetting($name, $value, $themeId);

        return new FloatSetting($name, $value);
    }

    public function changeBooleanSetting(ID $name, bool $value, string $themeId): BooleanSetting
    {
        $this->themeSettingRepository->saveBooleanSetting($name, $value, $themeId);

        return new BooleanSetting($name, $value);
    }

    public function changeStringSetting(ID $name, string $value, string $themeId): StringSetting
    {
        $this->themeSettingRepository->saveStringSetting($name, $value, $themeId);

        return new StringSetting($name, $value);
    }

    public function changeSelectSetting(ID $name, string $value, string $themeId): StringSetting
    {
        $this->themeSettingRepository->saveSelectSetting($name, $value, $themeId);

        return new StringSetting($name, $value);
    }

    public function changeCollectionSetting(ID $name, string $value, string $themeId): StringSetting
    {
        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollection($value);
        }

        $this->themeSettingRepository->saveCollectionSetting($name, $arrayValue, $themeId);

        return new StringSetting($name, $value);
    }

    public function changeAssocCollectionSetting(ID $name, string $value, string $themeId): StringSetting
    {
        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollection($value);
        }

        $this->themeSettingRepository->saveAssocCollectionSetting($name, $arrayValue, $themeId);

        return new StringSetting($name, $value);
    }
}
