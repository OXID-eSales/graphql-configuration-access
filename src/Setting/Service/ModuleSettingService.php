<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingService implements ModuleSettingServiceInterface
{
    public function __construct(
        private ModuleSettingRepositoryInterface $moduleSettingRepository
    ) {}

    public function getIntegerSetting(ID $name, $moduleId): IntegerSetting
    {
        return $this->moduleSettingRepository->getIntegerSetting($name, $moduleId);
    }

    public function getFloatSetting(ID $name, $moduleId): FloatSetting
    {
        return $this->moduleSettingRepository->getFloatSetting($name, $moduleId);
    }

    public function getBooleanSetting(ID $name, $moduleId): BooleanSetting
    {
        return $this->moduleSettingRepository->getBooleanSetting($name, $moduleId);
    }

    public function getStringSetting(ID $name, $moduleId): StringSetting
    {
        return $this->moduleSettingRepository->getStringSetting($name, $moduleId);
    }

    public function getCollectionSetting(ID $name, $moduleId): StringSetting
    {
        return $this->moduleSettingRepository->getCollectionSetting($name, $moduleId);
    }

    public function changeIntegerSetting(ID $name, int $value, string $moduleId):IntegerSetting
    {
        $this->settingRepository->saveIntegerSetting($name, $value, $moduleId);

        return new IntegerSetting($name, '', $value);
    }

    public function changeFloatSetting(ID $name, float $value, string $moduleId):FloatSetting
    {
        $this->settingRepository->saveFloatSetting($name, $value, $moduleId);

        return new FloatSetting($name, '', $value);
    }

    public function changeBooleanSetting(ID $name, bool $value, string $moduleId):BooleanSetting
    {
        $this->settingRepository->saveBooleanSetting($name, $value, $moduleId);

        return new BooleanSetting($name, '', $value);
    }

    public function changeStringSetting(ID $name, string $value, string $moduleId):StringSetting
    {
        $this->settingRepository->saveStringSetting($name, $value, $moduleId);

        return new StringSetting($name, '', $value);
    }
}
