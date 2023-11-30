<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;

interface ModuleSettingRepositoryInterface
{
    public function getIntegerSetting(string $name, string $moduleId): int;

    public function getFloatSetting(string $name, string $moduleId): float;

    public function getBooleanSetting(string $name, string $moduleId): bool;

    public function getStringSetting(string $name, string $moduleId): string;

    public function getCollectionSetting(string $name, string $moduleId): array;

    public function saveIntegerSetting(string $name, int $value, string $moduleId): void;

    public function saveFloatSetting(string $name, float $value, string $moduleId): void;

    public function saveBooleanSetting(string $name, bool $value, string $moduleId): void;

    public function saveStringSetting(string $name, string $value, string $moduleId): void;

    public function saveCollectionSetting(string $name, array $value, string $moduleId): void;

    /**
     * @return Setting[]
     */
    public function getSettingsList(string $moduleId): array;
}
