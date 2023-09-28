<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface SettingServiceInterface
{
    public function getModuleIntegerSetting(ID $name, $moduleId): IntegerSetting;
}
