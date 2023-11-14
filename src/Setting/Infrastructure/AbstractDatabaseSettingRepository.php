<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
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
    public function __construct(
        private BasicContextInterface $basicContext,
        private EventDispatcherInterface $eventDispatcher,
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        protected ShopSettingEncoderInterface $shopSettingEncoder
    ) {
    }

    protected function throwGetterNotFoundException(string $typeString)
    {
        $aOrAn = (preg_match('/^[aeiou]/i', $typeString)) ? 'an' : 'a';
        throw new NotFound("The queried name couldn't be found as $aOrAn $typeString configuration");
    }

    protected function throwSetterNotFoundException(string $typeString, string $name)
    {
        throw new NotFound('The ' . $typeString . ' setting "' . $name . '" doesn\'t exist');
    }

    protected function isFloatString(string $number): bool
    {
        return is_numeric($number) && str_contains($number, '.') !== false;
    }

    protected function getSettingValue(ID $name, string $fieldType, string $theme = ''): string
    {
        if ($theme) {
            $theme = 'theme:' . $theme;
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

        if ($value === false) {
            throw new NotFound('The requested configuration was not found');
        }

        return $value;
    }

    protected function getSettingTypes(string $theme = ''): array
    {
        $themeCondition = (!empty($theme)) ? 'theme:' . $theme : '';
        $shopId = $this->basicContext->getCurrentShopId();

        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('c.oxvarname')
            ->addSelect('c.oxvartype')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                ':module' => $themeCondition,
                ':shopId' => $shopId
            ]);
        $result = $queryBuilder->execute();
        $value = $result->fetchAllKeyValue();

        $notFoundLocation = (!empty($theme)) ? 'theme: "' . $theme . '"' : 'shopID: "' . $shopId . '"';
        if ($value === []) {
            throw new NotFound('No configurations found for ' . $notFoundLocation);
        }

        return $value;
    }

    protected function saveSettingValue(ID $name, string $themeId, string $value): void
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

        $affectedRows = $queryBuilder->execute();
        if ($affectedRows === 0) {
            throw new NotFound('No configurations found for ' . $themeId);
        }

        $this->eventDispatcher->dispatch(
            new ThemeSettingChangedEvent(
                $name->val(),
                $shopId,
                $themeId
            )
        );
    }
}
