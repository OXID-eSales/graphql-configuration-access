<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

final class ShopSettingRepository extends AbstractDatabaseSettingRepository implements ShopSettingRepositoryInterface
{
    public function getInteger(ID $name): int
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER);

        if ($value === False || $this->isFloatString($value)) {
            $this->throwNotFoundException('integer');
        }

        return (int)$value;
    }

    public function getFloat(ID $name): float
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER);

        if ($value === False || !$this->isFloatString($value)) {
            $this->throwNotFoundException('float');
        }

        return (float)$value;
    }

    public function getBoolean(ID $name): bool
    {
        $value = $this->getSettingValue($name, FieldType::BOOLEAN);

        if ($value === False) {
            $this->throwNotFoundException('boolean');
        }

        return (bool)$value;
    }

    public function getString(ID $name): string
    {
        $value = $this->getSettingValue($name, FieldType::STRING);

        if ($value === False) {
            $this->throwNotFoundException('string');
        }

        return $value;
    }

    public function getSelect(ID $name): string
    {
        $value = $this->getSettingValue($name, FieldType::SELECT);

        if ($value === False) {
            $this->throwNotFoundException('select');
        }

        return $value;
    }

    public function getCollection(ID $name): array
    {
        $value = $this->getSettingValue($name, FieldType::ARRAY);

        if ($value === False) {
            $this->throwNotFoundException('collection');
        }

        return unserialize($value);
    }

    public function getAssocCollection(ID $name): array
    {
        $value = $this->getSettingValue($name, FieldType::ASSOCIATIVE_ARRAY);

        if ($value === False) {
            $this->throwNotFoundException('associative collection');
        }

        return unserialize($value);
    }
}
