<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ThemeSettingServiceInterface
{
    public function getIntegerSetting(ID $name, $themeId): IntegerSetting;
}
