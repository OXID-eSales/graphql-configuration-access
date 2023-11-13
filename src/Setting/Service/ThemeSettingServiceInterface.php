<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ThemeSettingServiceInterface
{
    public function getIntegerSetting(ID $name, string $themeId): IntegerSetting;
    public function getFloatSetting(ID $name, string $themeId): FloatSetting;
    public function getBooleanSetting(ID $name, string $themeId): BooleanSetting;
    public function getStringSetting(ID $name, string $themeId): StringSetting;
    public function getSelectSetting(ID $name, string $themeId): StringSetting;
    public function getCollectionSetting(ID $name, string $themeId): StringSetting;
    public function getAssocCollectionSetting(ID $name, string $themeId): StringSetting;
    /**
     * @return SettingType[]
     */
    public function getSettingsList(string $themeId): array;
    public function changeIntegerSetting(ID $name, int $value, string $themeId): IntegerSetting;
    public function changeFloatSetting(ID $name, float $value, string $themeId): FloatSetting;
    public function changeBooleanSetting(ID $name, bool $value, string $themeId): BooleanSetting;
    public function changeStringSetting(ID $name, string $value, string $themeId): StringSetting;
    public function changeSelectSetting(ID $name, string $value, string $themeId): StringSetting;
    public function changeCollectionSetting(ID $name, string $value, string $themeId): StringSetting;
    public function changeAssocCollectionSetting(ID $name, string $value, string $themeId): StringSetting;
}
