<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ThemeSettingServiceInterface
{
    public function getIntegerSetting(ID $name, $themeId): IntegerSetting;
    public function getFloatSetting(ID $name, $themeId): FloatSetting;
    public function getBooleanSetting(ID $name, $themeId): BooleanSetting;
    public function getStringSetting(ID $name, $themeId): StringSetting;
    public function getSelectSetting(ID $name, $themeId): StringSetting;
}
