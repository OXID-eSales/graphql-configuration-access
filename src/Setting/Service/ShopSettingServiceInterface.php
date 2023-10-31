<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ShopSettingServiceInterface
{
    public function getIntegerSetting(ID $name): IntegerSetting;
    public function getFloatSetting(ID $name): FloatSetting;
    public function getBooleanSetting(ID $name): BooleanSetting;
}
