<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingRepository extends AbstractDatabaseSettingRepository implements ThemeSettingRepositoryInterface
{
    public function getInteger(ID $name, string $themeId): int
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER, $themeId);

        if ($value === False || $this->isFloatString($value)) {
            $this->throwNotFoundException('integer');
        }

        return (int)$value;
    }

    public function getFloat(ID $name, string $themeId): float
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER, $themeId);

        if ($value === False || !$this->isFloatString($value)) {
            $this->throwNotFoundException('float');
        }

        return (float)$value;
    }

    public function getBoolean(ID $name, string $themeId): bool
    {
        $value = $this->getSettingValue($name, FieldType::BOOLEAN, $themeId);

        if ($value === False) {
           $this->throwNotFoundException('boolean');
        }

        return (bool)$value;
    }

    public function getString(ID $name, string $themeId): string
    {
        $value = $this->getSettingValue($name, FieldType::STRING, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('string');
        }

        return $value;
    }

    public function getSelect(ID $name, string $themeId): string
    {
        $value = $this->getSettingValue($name, FieldType::SELECT, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('select');
        }

        return $value;
    }

    public function getCollection(ID $name, string $themeId): array
    {
        $value = $this->getSettingValue($name, FieldType::ARRAY, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('collection');
        }

        return unserialize($value);
    }

    public function getAssocCollection(ID $name, string $themeId): array
    {
        $value = $this->getSettingValue($name, FieldType::ASSOCIATIVE_ARRAY, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('associative collection');
        }

        return unserialize($value);
    }

    public function saveIntegerSetting(ID $name, int $value, string $themeId): void
    {
        $this->getInteger($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::NUMBER, $value);
    }

    public function saveFloatSetting(ID $name, float $value, string $themeId): void
    {
        $this->getFloat($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::NUMBER, $value);
    }

    public function saveBooleanSetting(ID $name, bool $value, string $themeId): void
    {
        $this->getBoolean($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::BOOLEAN, $value);
    }

    public function saveStringSetting(ID $name, string $value, string $themeId): void
    {
        $this->getString($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::STRING, $value);
    }

    public function saveSelectSetting(ID $name, string $value, string $themeId): void
    {
        $this->getSelect($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::SELECT, $value);
    }

    public function saveCollectionSetting(ID $name, array $value, string $themeId): void
    {
        $this->getCollection($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::ARRAY, $value);
    }

    public function saveAssocCollectionSetting(ID $name, array $value, string $themeId): void
    {
        $this->getAssocCollection($name, $themeId);
        $this->saveSettingValue($name, $themeId, FieldType::ASSOCIATIVE_ARRAY, $value);
    }
}
