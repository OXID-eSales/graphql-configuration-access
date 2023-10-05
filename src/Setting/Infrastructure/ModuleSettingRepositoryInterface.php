<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingRepositoryInterface
{
    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting;
}
