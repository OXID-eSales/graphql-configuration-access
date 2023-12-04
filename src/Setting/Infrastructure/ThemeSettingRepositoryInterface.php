<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

interface ThemeSettingRepositoryInterface
{
    public function getInteger(string $name, string $themeId): int;

    public function getFloat(string $name, string $themeId): float;

    public function getBoolean(string $name, string $themeId): bool;

    public function getString(string $name, string $themeId): string;

    public function getSelect(string $name, string $themeId): string;

    public function getCollection(string $name, string $themeId): array;

    public function getAssocCollection(string $name, string $themeId): array;

    /**
     * @return array<string, string>
     */
    public function getSettingsList(string $themeId): array;

    public function saveIntegerSetting(string $name, int $value, string $themeId): void;

    public function saveFloatSetting(string $name, float $value, string $themeId): void;

    public function saveBooleanSetting(string $name, bool $value, string $themeId): void;

    public function saveStringSetting(string $name, string $value, string $themeId): void;

    public function saveSelectSetting(string $name, string $value, string $themeId): void;

    public function saveCollectionSetting(string $name, array $value, string $themeId): void;

    public function saveAssocCollectionSetting(string $name, array $value, string $themeId): void;
}
