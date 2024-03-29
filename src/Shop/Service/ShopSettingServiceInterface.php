<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Shop\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;

interface ShopSettingServiceInterface
{
    public function getIntegerSetting(string $name): IntegerSetting;

    public function getFloatSetting(string $name): FloatSetting;

    public function getBooleanSetting(string $name): BooleanSetting;

    public function getStringSetting(string $name): StringSetting;

    public function getSelectSetting(string $name): StringSetting;

    public function getCollectionSetting(string $name): StringSetting;

    public function getAssocCollectionSetting(string $name): StringSetting;

    /**
     * @return SettingType[]
     */
    public function getSettingsList(): array;

    public function changeIntegerSetting(string $name, int $value): IntegerSetting;

    public function changeFloatSetting(string $name, float $value): FloatSetting;

    public function changeBooleanSetting(string $name, bool $value): BooleanSetting;

    public function changeStringSetting(string $name, string $value): StringSetting;

    public function changeSelectSetting(string $name, string $value): StringSetting;

    public function changeCollectionSetting(string $name, string $value): StringSetting;

    public function changeAssocCollectionSetting(string $name, string $value): StringSetting;
}
