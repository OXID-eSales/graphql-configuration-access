<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingServiceInterface
{
    public function getModuleIntegerSetting(ID $name, string $moduleId): IntegerSetting;
    public function getModuleFloatSetting(ID $name, string $moduleId): FloatSetting;
    public function getModuleBooleanSetting(ID $name, string $moduleId): BooleanSetting;
    public function getModuleStringSetting(ID $name, string $moduleId): StringSetting;
    public function getModuleCollectionSetting(ID $name, string $moduleId): StringSetting;
}
