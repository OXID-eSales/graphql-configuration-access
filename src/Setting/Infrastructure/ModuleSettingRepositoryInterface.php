<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingRepositoryInterface
{
    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting;
    public function getFloatSetting(ID $name, string $moduleId): FloatSetting;
    public function getBooleanSetting(ID $name, string $moduleId): BooleanSetting;
    public function getStringSetting(ID $name, string $moduleId): StringSetting;
    public function getCollectionSetting(ID $name, string $moduleId): StringSetting;
    public function saveIntegerSetting(ID $name, int $value, string $moduleId): void;
    public function saveFloatSetting(ID $name, float $value, string $moduleId): void;
    public function saveBooleanSetting(ID $name, bool $value, string $moduleId): void;
    public function saveStringSetting(ID $name, string $value, string $moduleId): void;
    public function saveCollectionSetting(ID $name, array $value, string $moduleId): void;

    /**
     * @return Setting[]
     */
    public function getSettingsList(string $moduleId): array;
}
