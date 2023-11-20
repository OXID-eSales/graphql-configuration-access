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

class ThemeSettingRepository extends AbstractDatabaseSettingRepository implements ThemeSettingRepositoryInterface
{
    public function getInteger(ID $name, string $themeId): int
    {
        $fieldType = FieldType::NUMBER;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('integer');
        }

        if ($this->isFloatString($encodedValue)) {
            throw new UnexpectedValueException('The queried configuration was found as a float, not an integer');
        }

        return (int)$this->shopSettingEncoder->decode($fieldType, $encodedValue);
    }

    public function getFloat(ID $name, string $themeId): float
    {
        $fieldType = FieldType::NUMBER;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('float');
        }

        if (!$this->isFloatString($encodedValue)) {
            throw new UnexpectedValueException('The queried configuration was found as an integer, not a float');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return (float)$value;
    }

    public function getBoolean(ID $name, string $themeId): bool
    {
        $fieldType = FieldType::BOOLEAN;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('boolean');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return (bool)$value;
    }

    public function getString(ID $name, string $themeId): string
    {
        $fieldType = FieldType::STRING;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('string');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getSelect(ID $name, string $themeId): string
    {
        $fieldType = FieldType::SELECT;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('select');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getCollection(ID $name, string $themeId): array
    {
        $fieldType = FieldType::ARRAY;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('collection');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getAssocCollection(ID $name, string $themeId): array
    {
        $fieldType = FieldType::ASSOCIATIVE_ARRAY;
        try {
            $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('associative collection');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getSettingsList(string $themeId): array
    {
        return $this->getSettingTypes($themeId);
    }

    public function saveIntegerSetting(ID $name, int $value, string $themeId): void
    {
        $value = $this->shopSettingEncoder->encode(FieldType::NUMBER, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveFloatSetting(ID $name, float $value, string $themeId): void
    {
        $value = $this->shopSettingEncoder->encode(FieldType::NUMBER, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveBooleanSetting(ID $name, bool $value, string $themeId): void
    {
        $value = $this->shopSettingEncoder->encode(FieldType::BOOLEAN, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveStringSetting(ID $name, string $value, string $themeId): void
    {
        $value = $this->shopSettingEncoder->encode(FieldType::STRING, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveSelectSetting(ID $name, string $value, string $themeId): void
    {
        $value = $this->shopSettingEncoder->encode(FieldType::SELECT, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveCollectionSetting(ID $name, array $value, string $themeId): void
    {
        $value = $this->shopSettingEncoder->encode(FieldType::ARRAY, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveAssocCollectionSetting(ID $name, array $value, string $themeId): void
    {
        // TODO: Implement saveAssocCollectionSetting() method.
    }
}
