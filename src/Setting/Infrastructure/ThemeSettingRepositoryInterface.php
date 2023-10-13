<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ThemeSettingRepositoryInterface
{
    public function getIntegerSetting(ID $name, string $themeId): IntegerSetting;
}
