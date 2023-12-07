<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;

interface ModuleSettingServiceInterface
{
    public function getIntegerSetting(string $name, string $moduleId): IntegerSetting;

    public function getFloatSetting(string $name, string $moduleId): FloatSetting;

    public function getBooleanSetting(string $name, string $moduleId): BooleanSetting;

    public function getStringSetting(string $name, string $moduleId): StringSetting;

    public function getCollectionSetting(string $name, string $moduleId): StringSetting;

    public function changeIntegerSetting(string $name, int $value, string $moduleId): IntegerSetting;

    public function changeFloatSetting(string $name, float $value, string $moduleId): FloatSetting;

    public function changeBooleanSetting(string $name, bool $value, string $moduleId): BooleanSetting;

    public function changeStringSetting(string $name, string $value, string $moduleId): StringSetting;

    public function changeCollectionSetting(string $name, string $value, string $moduleId): StringSetting;

    /**
     * @return SettingType[]
     */
    public function getSettingsList(string $moduleId): array;
}
