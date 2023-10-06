<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingServiceInterface
{
    public function getModuleIntegerSetting(ID $name, $moduleId): IntegerSetting;
    public function getModuleFloatSetting(ID $name, $moduleId): FloatSetting;
    public function getModuleBooleanSetting(ID $name, $moduleId): BooleanSetting;
    public function getModuleStringSetting(ID $name, $moduleId): StringSetting;
}
