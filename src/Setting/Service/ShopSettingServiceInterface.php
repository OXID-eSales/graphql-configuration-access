<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

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
