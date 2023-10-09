<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingServiceInterface
{
    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting;
    public function getFloatSetting(ID $name, string $moduleId): FloatSetting;
    public function getBooleanSetting(ID $name, string $moduleId): BooleanSetting;
    public function getStringSetting(ID $name, string $moduleId): StringSetting;
    public function getCollectionSetting(ID $name, string $moduleId): StringSetting;
}
