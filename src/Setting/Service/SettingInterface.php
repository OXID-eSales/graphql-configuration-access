<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface SettingInterface
{
    public function getModuleIntegerSetting(ID $name, $moduleId): IntegerSetting;
}
