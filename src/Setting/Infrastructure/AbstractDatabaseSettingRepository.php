<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * TODO: This class will probably removed in the future as the ShopSettingRepository will be reimplemented differently
 */
abstract class AbstractDatabaseSettingRepository
{
    public function __construct(QueryBuilderFactoryInterface $queryBuilderFactory)
    {
        $this->queryBuilder = $queryBuilderFactory->create();
    }

    protected function throwNotFoundException(string $typeString)
    {
        $aOrAn = (preg_match('/^[aeiou]/i', $typeString)) ? 'an' : 'a';
        throw new NotFound("The queried name couldn't be found as $aOrAn $typeString configuration");
    }

    protected function isFloatString(string $number): bool
    {
        return is_numeric($number) && str_contains($number, '.') !== false;
    }

    protected function getSettingValue(ID $name, string $fieldType, string $theme = ''): string
    {
        if ($theme) {
            $theme = 'theme:'.$theme;
        }

        $this->queryBuilder->select('c.oxvarvalue')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxvarname = :name')
            ->andWhere('c.oxvartype = :type')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                ':module' => $theme,
                ':name' => $name->val(),
                ':type' => $fieldType,
                ':shopId' => EshopRegistry::getConfig()->getShopId()
            ]);
        $result = $this->queryBuilder->execute();
        $value = $result->fetchOne();

        if ($value === false) {
            throw new NotFound('The requested configuration was not found');
        }

        return $value;
    }
}
