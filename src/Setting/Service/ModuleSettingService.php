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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;

final class ModuleSettingService implements ModuleSettingServiceInterface
{
    public function __construct(
        private ModuleSettingRepositoryInterface $moduleSettingRepository,
        private JsonServiceInterface $jsonService
    ) {
    }

    public function getIntegerSetting(string $name, string $moduleId): IntegerSetting
    {
        return new IntegerSetting(
            $name,
            $this->moduleSettingRepository->getIntegerSetting($name, $moduleId)
        );
    }

    public function getFloatSetting(string $name, string $moduleId): FloatSetting
    {
        return new FloatSetting(
            $name,
            $this->moduleSettingRepository->getFloatSetting($name, $moduleId)
        );
    }

    public function getBooleanSetting(string $name, string $moduleId): BooleanSetting
    {
        return new BooleanSetting(
            $name,
            $this->moduleSettingRepository->getBooleanSetting($name, $moduleId)
        );
    }

    public function getStringSetting(string $name, string $moduleId): StringSetting
    {
        return new StringSetting(
            $name,
            $this->moduleSettingRepository->getStringSetting($name, $moduleId)
        );
    }

    public function getCollectionSetting(string $name, string $moduleId): StringSetting
    {
        $collection = $this->moduleSettingRepository->getCollectionSetting($name, $moduleId);

        return new StringSetting(
            $name,
            $this->jsonService->jsonEncodeArray($collection)
        );
    }

    public function changeIntegerSetting(string $name, int $value, string $moduleId): IntegerSetting
    {
        $this->moduleSettingRepository->saveIntegerSetting($name, $value, $moduleId);

        return $this->getIntegerSetting($name, $moduleId);
    }

    public function changeFloatSetting(string $name, float $value, string $moduleId): FloatSetting
    {
        $this->moduleSettingRepository->saveFloatSetting($name, $value, $moduleId);

        return $this->getFloatSetting($name, $moduleId);
    }

    public function changeBooleanSetting(string $name, bool $value, string $moduleId): BooleanSetting
    {
        $this->moduleSettingRepository->saveBooleanSetting($name, $value, $moduleId);

        return $this->getBooleanSetting($name, $moduleId);
    }

    public function changeStringSetting(string $name, string $value, string $moduleId): StringSetting
    {
        $this->moduleSettingRepository->saveStringSetting($name, $value, $moduleId);

        return $this->getStringSetting($name, $moduleId);
    }

    public function changeCollectionSetting(string $name, string $value, string $moduleId): StringSetting
    {
        $this->moduleSettingRepository->saveCollectionSetting(
            $name,
            $this->jsonService->jsonDecodeCollection($value),
            $moduleId
        );

        return $this->getCollectionSetting($name, $moduleId);
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
            $settingTypes[] = new SettingType($setting->getName(), $setting->getType());
        }

        return $settingTypes;
    }
}
