<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Event\ShopConfigurationChangedEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
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
        private ShopConfigurationSettingDaoInterface $shopConfigurationDao,
        private ShopSettingEncoderInterface $shopSettingEncoder,
        QueryBuilderFactoryInterface $queryBuilderFactory,
    ) {
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

    protected function getSettingValue(ID $name, string $fieldType, string $theme = ''): mixed
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
                ':shopId' => $this->basicContext->getCurrentShopId(),
            ]);
        $result = $this->queryBuilder->execute();
        $value = $result->fetchOne();
        return $value;
    }

    protected function saveSettingValue(ID $name, string $themeId, string $fieldType, mixed $value): void
    {
        $shopId = $this->basicContext->getCurrentShopId();

        $this->queryBuilder
            ->update('oxconfig')
            ->where($this->queryBuilder->expr()->eq('oxvarname', ':name'))
            ->andWhere($this->queryBuilder->expr()->eq('oxshopid', ':shopId'))
            ->andWhere($this->queryBuilder->expr()->eq('oxmodule', ':themeId'))
            ->set('oxvarvalue', ':value')
            ->setParameters([
                'shopId' => $shopId,
                'name' => $name->val(),
                'themeId' => 'theme:' . $themeId,
                'value' => $this->shopSettingEncoder->encode(
                    $fieldType,
                    $value
                ),
            ]);

        $this->queryBuilder->execute();

        $this->eventDispatcher->dispatch(
            new ShopConfigurationChangedEvent(
                $name->val(),
                $shopId,
            )
        );
    }
}
