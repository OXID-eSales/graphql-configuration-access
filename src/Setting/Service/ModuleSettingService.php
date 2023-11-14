<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingService implements ModuleSettingServiceInterface
{
    public function __construct(
        private ModuleSettingRepositoryInterface $moduleSettingRepository
    ) {
    }

    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingRepository->getIntegerSetting($name, $moduleId);
    }

    public function getFloatSetting(ID $name, string $moduleId): FloatSetting
    {
        return $this->moduleSettingRepository->getFloatSetting($name, $moduleId);
    }

    public function getBooleanSetting(ID $name, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingRepository->getBooleanSetting($name, $moduleId);
    }

    public function getStringSetting(ID $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingRepository->getStringSetting($name, $moduleId);
    }

    public function getCollectionSetting(ID $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingRepository->getCollectionSetting($name, $moduleId);
    }

    public function changeIntegerSetting(ID $name, int $value, string $moduleId): IntegerSetting
    {
        $this->moduleSettingRepository->saveIntegerSetting($name, $value, $moduleId);

        return new IntegerSetting($name, $value);
    }

    public function changeFloatSetting(ID $name, float $value, string $moduleId): FloatSetting
    {
        $this->moduleSettingRepository->saveFloatSetting($name, $value, $moduleId);

        return new FloatSetting($name, $value);
    }

    public function changeBooleanSetting(ID $name, bool $value, string $moduleId): BooleanSetting
    {
        $this->moduleSettingRepository->saveBooleanSetting($name, $value, $moduleId);

        return new BooleanSetting($name, $value);
    }

    public function changeStringSetting(ID $name, string $value, string $moduleId): StringSetting
    {
        $this->moduleSettingRepository->saveStringSetting($name, $value, $moduleId);

        return new StringSetting($name, $value);
    }

    public function changeCollectionSetting(ID $name, string $value, string $moduleId): StringSetting
    {
        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollection($value);
        }

        $this->moduleSettingRepository->saveCollectionSetting($name, $arrayValue, $moduleId);

        return new StringSetting($name, $value);
    }

    /**
     * @return SettingType[]
     */
    public function getSettingsList(string $moduleId): array
    {
        $settingsList = $this->moduleSettingRepository->getSettingsList($moduleId);
        $settingTypes = [];
        /** @var Setting $setting */
        foreach ($settingsList as $setting) {
            $settingTypes[] = new SettingType(new ID($setting->getName()), $setting->getType());
        }

        return $settingTypes;
    }
}
