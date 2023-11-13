<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Theme\Event\ThemeSettingChangedEvent;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * TODO: This class will probably removed in the future as the ShopSettingRepository will be reimplemented differently
 */
abstract class AbstractDatabaseSettingRepository
{
    private QueryBuilder $queryBuilder;

    public function __construct(
        private BasicContextInterface $basicContext,
        private EventDispatcherInterface $eventDispatcher,
        private QueryBuilderFactoryInterface $queryBuilderFactory
    ) {
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

    protected function getSettingValue(ID $name, string $fieldType, string $theme = ''): mixed
    {
        if ($theme) {
            $theme = 'theme:'.$theme;
        }

        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('c.oxvarvalue')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxvarname = :name')
            ->andWhere('c.oxvartype = :type')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                'module' => $theme,
                'name' => $name->val(),
                'type' => $fieldType,
                'shopId' => $this->basicContext->getCurrentShopId(),
            ]);
        $result = $queryBuilder->execute();
        $value = $result->fetchOne();
        return $value;
    }

    protected function saveSettingValue(ID $name, string $themeId, mixed $value): void
    {
        $shopId = $this->basicContext->getCurrentShopId();

        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder
            ->update('oxconfig')
            ->where($queryBuilder->expr()->eq('oxvarname', ':name'))
            ->andWhere($queryBuilder->expr()->eq('oxshopid', ':shopId'))
            ->andWhere($queryBuilder->expr()->eq('oxmodule', ':themeId'))
            ->set('oxvarvalue', ':value')
            ->setParameters([
                'shopId' => $shopId,
                'name' => $name->val(),
                'themeId' => 'theme:' . $themeId,
                'value' => $value
            ]);

        $queryBuilder->execute();

        $this->eventDispatcher->dispatch(
            new ThemeSettingChangedEvent(
                $name->val(),
                $shopId,
                $themeId
            )
        );
    }
}
