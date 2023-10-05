<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingServiceInterface
{
    public function getModuleIntegerSetting(ID $name, $moduleId): IntegerSetting;
    public function getModuleFloatSetting(ID $name, $moduleId): FloatSetting;
}
