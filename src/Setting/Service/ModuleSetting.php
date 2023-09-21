<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSetting implements ModuleSettingInterface
{
    public function __construct(
        private ModuleSettingRepository $settingRepository
    ) {}

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
