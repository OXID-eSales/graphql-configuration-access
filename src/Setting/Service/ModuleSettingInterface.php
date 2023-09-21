<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingInterface
{
    public function changeIntegerSetting(ID $name, int $value, string $moduleId): IntegerSetting;
    public function changeFloatSetting(ID $name, float $value, string $moduleId): FloatSetting;
    public function changeBooleanSetting(ID $name, bool $value, string $moduleId): BooleanSetting;
    public function changeStringSetting(ID $name, string $value, string $moduleId): StringSetting;
}
