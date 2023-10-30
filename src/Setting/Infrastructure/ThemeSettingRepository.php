<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingRepository implements ThemeSettingRepositoryInterface
{
    public function __construct(private QueryBuilderFactoryInterface $queryBuilderFactory)
    {
        $this->queryBuilder = $this->queryBuilderFactory->create();
    }

    public function getInteger(ID $name, string $themeId): int
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::NUMBER);

        if ($value === False || $this->isFloatString($value)) {
            throw new NotFound('The queried name couldn\'t be found as an integer configuration');
        }

        return (int)$value;
    }

    public function getFloat(ID $name, string $themeId): float
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::NUMBER);

        if ($value === False || !$this->isFloatString($value)) {
            throw new NotFound('The queried name couldn\'t be found as a float configuration');
        }

        return (float)$value;
    }

    public function getBoolean(ID $name, string $themeId): bool
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::BOOLEAN);

        if ($value === False) {
           throw new NotFound('The queried name couldn\'t be found as a boolean configuration');
        }

        return (bool)$value;
    }

    public function getString(ID $name, string $themeId): string
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::STRING);

        if ($value === False) {
            throw new NotFound('The queried name couldn\'t be found as a string configuration');
        }

        return $value;
    }

    public function getSelect(ID $name, string $themeId): string
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::SELECT);

        if ($value === False) {
            throw new NotFound('The queried name couldn\'t be found as a select configuration');
        }

        return $value;
    }

    public function getCollection(ID $name, string $themeId): array
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::ARRAY);

        if ($value === False) {
            throw new NotFound('The queried name couldn\'t be found as a collection configuration');
        }

        return unserialize($value);
    }

    public function getAssocCollection(ID $name, string $themeId): array
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::ASSOCIATIVE_ARRAY);

        if ($value === False) {
            throw new NotFound('The queried name couldn\'t be found as an associative collection configuration');
        }

        return unserialize($value);
    }

    private function isFloatString(string $number): bool
    {
        return is_numeric($number) && str_contains($number, '.') !== false;
    }

    private function getSettingValue(string $themeId, ID $name, string $fieldType): mixed
    {
        $this->queryBuilder->select('c.oxvarvalue')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxvarname = :name')
            ->andWhere('c.oxvartype = :type')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                ':module' => 'theme:' . $themeId,
                ':name' => $name->val(),
                ':type' => $fieldType,
                ':shopId' => EshopRegistry::getConfig()->getShopId()
            ]);
        $result = $this->queryBuilder->execute();
        $value = $result->fetchOne();
        return $value;
    }
}
