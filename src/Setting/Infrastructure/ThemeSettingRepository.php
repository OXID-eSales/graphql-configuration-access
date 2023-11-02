<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\DatabaseFieldType;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingRepository extends AbstractDatabaseSettingRepository implements ThemeSettingRepositoryInterface
{
    public function getInteger(ID $name, string $themeId): int
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::NUMBER, $themeId);

        if ($value === False || $this->isFloatString($value)) {
            $this->throwNotFoundException('integer');
        }

        return (int)$value;
    }

    public function getFloat(ID $name, string $themeId): float
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::NUMBER, $themeId);

        if ($value === False || !$this->isFloatString($value)) {
            $this->throwNotFoundException('float');
        }

        return (float)$value;
    }

    public function getBoolean(ID $name, string $themeId): bool
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::BOOLEAN, $themeId);

        if ($value === False) {
           $this->throwNotFoundException('boolean');
        }

        return (bool)$value;
    }

    public function getString(ID $name, string $themeId): string
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::STRING, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('string');
        }

        return $value;
    }

    public function getSelect(ID $name, string $themeId): string
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::SELECT, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('select');
        }

        return $value;
    }

    public function getCollection(ID $name, string $themeId): array
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::ARRAY, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('collection');
        }

        return unserialize($value);
    }

    public function getAssocCollection(ID $name, string $themeId): array
    {
        $value = $this->getSettingValue($name, DatabaseFieldType::ASSOCIATIVE_ARRAY, $themeId);

        if ($value === False) {
            $this->throwNotFoundException('associative collection');
        }

        return unserialize($value);
    }
}
