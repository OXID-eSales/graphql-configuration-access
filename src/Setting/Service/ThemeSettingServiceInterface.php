<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;

interface ThemeSettingServiceInterface
{
    public function getIntegerSetting(string $name, string $themeId): IntegerSetting;

    public function getFloatSetting(string $name, string $themeId): FloatSetting;

    public function getBooleanSetting(string $name, string $themeId): BooleanSetting;

    public function getStringSetting(string $name, string $themeId): StringSetting;

    public function getSelectSetting(string $name, string $themeId): StringSetting;

    public function getCollectionSetting(string $name, string $themeId): StringSetting;

    public function getAssocCollectionSetting(string $name, string $themeId): StringSetting;

    /**
     * @return SettingType[]
     */
    public function getSettingsList(string $themeId): array;

    public function changeIntegerSetting(string $name, int $value, string $themeId): IntegerSetting;

    public function changeFloatSetting(string $name, float $value, string $themeId): FloatSetting;

    public function changeBooleanSetting(string $name, bool $value, string $themeId): BooleanSetting;

    public function changeStringSetting(string $name, string $value, string $themeId): StringSetting;

    public function changeSelectSetting(string $name, string $value, string $themeId): StringSetting;

    public function changeCollectionSetting(string $name, string $value, string $themeId): StringSetting;

    public function changeAssocCollectionSetting(string $name, string $value, string $themeId): StringSetting;
}
