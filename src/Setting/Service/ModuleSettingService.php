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
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingService implements ModuleSettingServiceInterface
{
    public function __construct(
        private ModuleSettingRepositoryInterface $moduleSettingRepository,
        private JsonServiceInterface $jsonService
    ) {
    }

    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting
    {
        return new IntegerSetting(
            $name,
            $this->moduleSettingRepository->getIntegerSetting((string)$name, $moduleId)
        );
    }

    public function getFloatSetting(ID $name, string $moduleId): FloatSetting
    {
        return new FloatSetting(
            $name,
            $this->moduleSettingRepository->getFloatSetting((string)$name, $moduleId)
        );
    }

    public function getBooleanSetting(ID $name, string $moduleId): BooleanSetting
    {
        return new BooleanSetting(
            $name,
            $this->moduleSettingRepository->getBooleanSetting((string)$name, $moduleId)
        );
    }

    public function getStringSetting(ID $name, string $moduleId): StringSetting
    {
        return new StringSetting(
            $name,
            $this->moduleSettingRepository->getStringSetting((string)$name, $moduleId)
        );
    }

    public function getCollectionSetting(ID $name, string $moduleId): StringSetting
    {
        $collection = $this->moduleSettingRepository->getCollectionSetting((string)$name, $moduleId);

        return new StringSetting(
            $name,
            $this->jsonService->jsonEncodeArray($collection)
        );
    }

    public function changeIntegerSetting(ID $name, int $value, string $moduleId): IntegerSetting
    {
        $this->moduleSettingRepository->saveIntegerSetting((string)$name, $value, $moduleId);

        return $this->getIntegerSetting($name, $moduleId);
    }

    public function changeFloatSetting(ID $name, float $value, string $moduleId): FloatSetting
    {
        $this->moduleSettingRepository->saveFloatSetting((string)$name, $value, $moduleId);

        return $this->getFloatSetting($name, $moduleId);
    }

    public function changeBooleanSetting(ID $name, bool $value, string $moduleId): BooleanSetting
    {
        $this->moduleSettingRepository->saveBooleanSetting((string)$name, $value, $moduleId);

        return $this->getBooleanSetting($name, $moduleId);
    }

    public function changeStringSetting(ID $name, string $value, string $moduleId): StringSetting
    {
        $this->moduleSettingRepository->saveStringSetting((string)$name, $value, $moduleId);

        return $this->getStringSetting($name, $moduleId);
    }

    public function changeCollectionSetting(ID $name, string $value, string $moduleId): StringSetting
    {
        $this->moduleSettingRepository->saveCollectionSetting(
            (string)$name,
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
            $settingTypes[] = new SettingType(new ID($setting->getName()), $setting->getType());
        }

        return $settingTypes;
    }
}
