<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForShopException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingTypeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingValueException;

interface ShopSettingRepositoryInterface
{
    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getInteger(string $name): int;

    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getFloat(string $name): float;

    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getBoolean(string $name): bool;

    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getString(string $name): string;

    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getSelect(string $name): string;

    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getCollection(string $name): array;

    /**
     * @throws WrongSettingTypeException
     * @throws WrongSettingValueException
     */
    public function getAssocCollection(string $name): array;

    /**
     * @throws NoSettingsFoundForShopException
     * @return array<string, string>
     */
    public function getSettingsList(): array;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveIntegerSetting(string $name, int $value): void;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveFloatSetting(string $name, float $value): void;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveBooleanSetting(string $name, bool $value): void;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveStringSetting(string $name, string $value): void;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveSelectSetting(string $name, string $value): void;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveCollectionSetting(string $name, array $value): void;

    /**
     * @throws WrongSettingTypeException
     */
    public function saveAssocCollectionSetting(string $name, array $value): void;
}
