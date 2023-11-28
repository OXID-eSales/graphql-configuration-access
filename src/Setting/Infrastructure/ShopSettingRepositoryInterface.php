<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

interface ShopSettingRepositoryInterface
{
    public function getInteger(string $name): int;

    public function getFloat(string $name): float;

    public function getBoolean(string $name): bool;

    public function getString(string $name): string;

    public function getSelect(string $name): string;

    public function getCollection(string $name): array;

    public function getAssocCollection(string $name): array;

    /**
     * @return array<string, string>
     */
    public function getSettingsList(): array;

    public function saveIntegerSetting(string $name, int $value): void;

    public function saveFloatSetting(string $name, float $value): void;

    public function saveBooleanSetting(string $name, bool $value): void;

    public function saveStringSetting(string $name, string $value): void;

    public function saveSelectSetting(string $name, string $value): void;

    public function saveCollectionSetting(string $name, array $value): void;

    public function saveAssocCollectionSetting(string $name, array $value): void;
}
