<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

final class ShopSettingRepository extends AbstractDatabaseSettingRepository implements ShopSettingRepositoryInterface
{
    public function getInteger(ID $name): int
    {
        try {
            $value = $this->getSettingValue($name, FieldType::NUMBER);
        } catch (NotFound $e) {
            $this->throwNotFoundException('integer');
        }

        if ($this->isFloatString($value)) {
            throw new UnexpectedValueException('The queried configuration was found as a float, not an integer');
        }

        return (int)$value;
    }

    public function getFloat(ID $name): float
    {
        try {
            $value = $this->getSettingValue($name, FieldType::NUMBER);
        } catch (NotFound $e) {
            $this->throwNotFoundException('float');
        }

        if (!$this->isFloatString($value)) {
            throw new UnexpectedValueException('The queried configuration was found as an integer, not a float');
        }

        return (float)$value;
    }

    public function getBoolean(ID $name): bool
    {
        try {
            $value = $this->getSettingValue($name, FieldType::BOOLEAN);
        } catch (NotFound $e) {
            $this->throwNotFoundException('boolean');
        }

        return (bool)$value;
    }

    public function getString(ID $name): string
    {
        try {
            $value = $this->getSettingValue($name, FieldType::STRING);
        } catch (NotFound $e) {
            $this->throwNotFoundException('string');
        }

        return $value;
    }

    public function getSelect(ID $name): string
    {
        try {
            $value = $this->getSettingValue($name, FieldType::SELECT);
        } catch (NotFound $e) {
            $this->throwNotFoundException('select');
        }

        return $value;
    }

    public function getCollection(ID $name): array
    {
        try {
            $value = $this->getSettingValue($name, FieldType::ARRAY);
        } catch (NotFound $e) {
            $this->throwNotFoundException('collection');
        }

        return unserialize($value);
    }

    public function getAssocCollection(ID $name): array
    {
        try {
            $value = $this->getSettingValue($name, FieldType::ASSOCIATIVE_ARRAY);
        } catch (NotFound $e) {
            $this->throwNotFoundException('associative collection');
        }

        return unserialize($value);
    }
}
