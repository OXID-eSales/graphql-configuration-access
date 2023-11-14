<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ShopSettingServiceInterface
{
    public function getIntegerSetting(ID $name): IntegerSetting;

    public function getFloatSetting(ID $name): FloatSetting;

    public function getBooleanSetting(ID $name): BooleanSetting;

    public function getStringSetting(ID $name): StringSetting;

    public function getSelectSetting(ID $name): StringSetting;

    public function getCollectionSetting(ID $name): StringSetting;

    public function getAssocCollectionSetting(ID $name): StringSetting;

    /**
     * @return SettingType[]
     */
    public function getSettingsList(): array;
}
