<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use TheCodingMachine\GraphQLite\Types\ID;

interface ThemeSettingRepositoryInterface
{
    public function getInteger(ID $name, string $themeId): int;

    public function getFloat(ID $name, string $themeId): float;

    public function getBoolean(ID $name, string $themeId): bool;

    public function getString(ID $name, string $themeId): string;

    public function getSelect(ID $name, string $themeId): string;

    public function getCollection(ID $name, string $themeId): array;

    public function getAssocCollection(ID $name, string $themeId): array;

    /**
     * @return array<string, string>
     */
    public function getSettingsList(string $themeId): array;

    public function saveIntegerSetting(ID $name, int $value, string $themeId): void;

    public function saveFloatSetting(ID $name, float $value, string $themeId): void;

    public function saveBooleanSetting(ID $name, bool $value, string $themeId): void;

    public function saveStringSetting(ID $name, string $value, string $themeId): void;

    public function saveSelectSetting(ID $name, string $value, string $themeId): void;

    public function saveCollectionSetting(ID $name, array $value, string $themeId): void;

    public function saveAssocCollectionSetting(ID $name, array $value, string $themeId): void;
}
