<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use TheCodingMachine\GraphQLite\Types\ID;

interface ModuleSettingRepositoryInterface
{
    public function getIntegerSetting(string $name, string $moduleId): int;

    public function getFloatSetting(string $name, string $moduleId): float;

    public function getBooleanSetting(string $name, string $moduleId): bool;

    public function getStringSetting(string $name, string $moduleId): string;

    public function getCollectionSetting(string $name, string $moduleId): array;

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
