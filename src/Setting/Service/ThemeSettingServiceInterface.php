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
}
