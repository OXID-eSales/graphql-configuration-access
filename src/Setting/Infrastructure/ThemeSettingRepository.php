<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingRepository extends AbstractDatabaseSettingRepository implements ThemeSettingRepositoryInterface
{
    private $queryBuilder;

    public function __construct(
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        private BasicContextInterface $basicContext
    ) {
        $this->queryBuilder = $this->queryBuilderFactory->create();
    }

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
                ':shopId' => $this->basicContext->getCurrentShopId()
            ]);
        $result = $this->queryBuilder->execute();
        $value = $result->fetchOne();
        return $value;
    }
}
