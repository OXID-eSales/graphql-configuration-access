<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use Doctrine\DBAL\Result;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Theme\Event\ThemeSettingChangedEvent;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use Psr\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

final class ShopSettingRepository implements ShopSettingRepositoryInterface
{
    public function __construct(
        private BasicContextInterface $basicContext,
        private EventDispatcherInterface $eventDispatcher,
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        protected ShopSettingEncoderInterface $shopSettingEncoder
    ) {
    }

    public function getInteger(ID $name): int
    {
        try {
            $value = $this->getSettingValue($name, FieldType::NUMBER);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('integer');
        }

        if ($this->isFloatString($value)) {
            throw new UnexpectedValueException('The queried configuration was found as a float, not an integer');
        }

        return (int)$value;
    }

    public function getFloat(ID $name): float
    {
        try {
            $value = $this->getSettingValue($name, FieldType::NUMBER);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('float');
        }

        if (!$this->isFloatString($value)) {
            throw new UnexpectedValueException('The queried configuration was found as an integer, not a float');
        }

        return (float)$value;
    }

    public function getBoolean(ID $name): bool
    {
        try {
            $value = $this->getSettingValue($name, FieldType::BOOLEAN);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('boolean');
        }

        return (bool)$value;
    }

    public function getString(ID $name): string
    {
        try {
            $value = $this->getSettingValue($name, FieldType::STRING);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('string');
        }

        return $value;
    }

    public function getSelect(ID $name): string
    {
        try {
            $value = $this->getSettingValue($name, FieldType::SELECT);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('select');
        }

        return $value;
    }

    public function getCollection(ID $name): array
    {
        try {
            $value = $this->getSettingValue($name, FieldType::ARRAY);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('collection');
        }

        return unserialize($value);
    }

    public function getAssocCollection(ID $name): array
    {
        try {
            $value = $this->getSettingValue($name, FieldType::ASSOCIATIVE_ARRAY);
        } catch (NotFound $e) {
            $this->throwGetterNotFoundException('associative collection');
        }

        return unserialize($value);
    }

    public function getSettingsList(): array
    {
        return $this->getSettingTypes();
    }

    protected function throwGetterNotFoundException(string $typeString): void
    {
        $aOrAn = (preg_match('/^[aeiou]/i', $typeString)) ? 'an' : 'a';
        throw new NotFound("The queried name couldn't be found as $aOrAn $typeString configuration");
    }

    protected function throwSetterNotFoundException(string $typeString, string $name): void
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

        /** @var Result $result */
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

        /** @var Result $result */
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
            throw new NotFound('Configuration not found for ' . $themeId);
        }

        $this->eventDispatcher->dispatch(
            new ThemeSettingChangedEvent(
                (string)$name,
                $shopId,
                $themeId
            )
        );
    }
}
