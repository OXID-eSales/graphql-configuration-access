<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForThemeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingValueException;

interface ThemeSettingRepositoryInterface
{
    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getInteger(string $name, string $themeId): int;

    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getFloat(string $name, string $themeId): float;

    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getBoolean(string $name, string $themeId): bool;

    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getString(string $name, string $themeId): string;

    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getSelect(string $name, string $themeId): string;

    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getCollection(string $name, string $themeId): array;

    /**
     * @throws NoSettingsFoundForThemeException
     * @throws WrongSettingValueException
     */
    public function getAssocCollection(string $name, string $themeId): array;

    /**
     * @throws NoSettingsFoundForThemeException
     * @return array<string, string>
     */
    public function getSettingsList(string $themeId): array;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveIntegerSetting(string $name, int $value, string $themeId): void;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveFloatSetting(string $name, float $value, string $themeId): void;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveBooleanSetting(string $name, bool $value, string $themeId): void;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveStringSetting(string $name, string $value, string $themeId): void;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveSelectSetting(string $name, string $value, string $themeId): void;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveCollectionSetting(string $name, array $value, string $themeId): void;

    /**
     * @throws NoSettingsFoundForThemeException
     */
    public function saveAssocCollectionSetting(string $name, array $value, string $themeId): void;
}
