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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

final class ShopSettingRepository implements ShopSettingRepositoryInterface
{
    public function __construct(private QueryBuilderFactoryInterface $queryBuilderFactory)
    {
        $this->queryBuilder = $this->queryBuilderFactory->create();
    }

    public function getInteger(ID $name): int
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER);

        if ($value === False || $this->isFloatString($value)) {
            throw new NotFound('The queried name couldn\'t be found as an integer configuration');
        }

        return (int)$value;
    }

    public function getFloat(ID $name): float
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER);

        if ($value === False || !$this->isFloatString($value)) {
            throw new NotFound('The queried name couldn\'t be found as a float configuration');
        }

        return (float)$value;
    }

    private function isFloatString(string $number): bool
    {
        return is_numeric($number) && str_contains($number, '.') !== false;
    }

    private function getSettingValue(ID $name, string $fieldType): mixed
    {
        $this->queryBuilder->select('c.oxvarvalue')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxvarname = :name')
            ->andWhere('c.oxvartype = :type')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                ':module' => '',
                ':name' => $name->val(),
                ':type' => $fieldType,
                ':shopId' => EshopRegistry::getConfig()->getShopId()
            ]);
        $result = $this->queryBuilder->execute();
        $value = $result->fetchOne();
        return $value;
    }
}
