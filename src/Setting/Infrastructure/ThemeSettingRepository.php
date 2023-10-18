<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

final class ThemeSettingRepository implements ThemeSettingRepositoryInterface
{
    public function __construct(private QueryBuilderFactoryInterface $queryBuilderFactory)
    {
        $this->queryBuilder = $this->queryBuilderFactory->create();
    }

    public function getIntegerSetting(ID $name, string $themeId): IntegerSetting
    {
        $value = $this->getSettingValue($themeId, $name);

        if ($value === False || $this->isFloatString($value)) {
            throw new UnexpectedValueException('The queried name couldn\'t be found as an integer configuration');
        }

        return new IntegerSetting($name, (int)$value);
    }

    public function getFloatSetting(ID $name, string $themeId): FloatSetting
    {
        $value = $this->getSettingValue($themeId, $name);

        if ($value === False || !$this->isFloatString($value)) {
            throw new UnexpectedValueException('The queried name couldn\'t be found as an float configuration');
        }

        return new FloatSetting($name, (float)$value);
    }

    private function isFloatString(string $number): bool
    {
        return is_numeric($number) && str_contains($number, '.') !== false;
    }

    private function getSettingValue(string $themeId, ID $name): mixed
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
                ':type' => FieldType::NUMBER,
                ':shopId' => EshopRegistry::getConfig()->getShopId()
            ]);
        $result = $this->queryBuilder->execute();
        $value = $result->fetchOne();
        return $value;
    }
}
