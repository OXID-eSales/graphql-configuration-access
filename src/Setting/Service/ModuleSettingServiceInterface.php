<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingServiceInterface
{
    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting;

    public function getFloatSetting(ID $name, string $moduleId): FloatSetting;

    public function getBooleanSetting(ID $name, string $moduleId): BooleanSetting;

    public function getStringSetting(ID $name, string $moduleId): StringSetting;

    public function getCollectionSetting(ID $name, string $moduleId): StringSetting;

    public function changeIntegerSetting(ID $name, int $value, string $moduleId): IntegerSetting;

    public function changeFloatSetting(ID $name, float $value, string $moduleId): FloatSetting;

    public function changeBooleanSetting(ID $name, bool $value, string $moduleId): BooleanSetting;

    public function changeStringSetting(ID $name, string $value, string $moduleId): StringSetting;

    public function changeCollectionSetting(ID $name, string $value, string $moduleId): StringSetting;

    /**
     * @return SettingType[]
     */
    public function getSettingsList(string $moduleId): array;
}
