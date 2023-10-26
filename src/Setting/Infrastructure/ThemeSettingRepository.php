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

    public function getIntegerSetting(ID $name, string $themeId): IntegerSetting
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::NUMBER);

        if ($value === False || $this->isFloatString($value)) {
            throw new NotFound('The queried name couldn\'t be found as an integer configuration');
        }

        return new IntegerSetting($name, (int)$value);
    }

    public function getFloatSetting(ID $name, string $themeId): FloatSetting
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::NUMBER);

        if ($value === False || !$this->isFloatString($value)) {
            throw new NotFound('The queried name couldn\'t be found as a float configuration');
        }

        return new FloatSetting($name, (float)$value);
    }

    public function getBooleanSetting(ID $name, string $themeId): BooleanSetting
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::BOOLEAN);

        if ($value === False) {
           throw new NotFound('The queried name couldn\'t be found as a boolean configuration');
        }

        return new BooleanSetting($name, (bool)$value);
    }

    public function getStringSetting(ID $name, string $themeId): StringSetting
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::STRING);

        if ($value === False) {
            throw new NotFound('The queried name couldn\'t be found as a string configuration');
        }

        return new StringSetting($name, $value);
    }

    public function getSelectSetting(ID $name, string $themeId): StringSetting
    {
        $value = $this->getSettingValue($themeId, $name, FieldType::SELECT);

        if ($value === False) {
            throw new NotFound('The queried name couldn\'t be found as a select configuration');
        }

        return new StringSetting($name, $value);
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
