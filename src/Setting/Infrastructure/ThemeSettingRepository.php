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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForThemeException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

class ThemeSettingRepository implements ThemeSettingRepositoryInterface
{
    public function __construct(
        private BasicContextInterface $basicContext,
        private EventDispatcherInterface $eventDispatcher,
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        protected ShopSettingEncoderInterface $shopSettingEncoder
    ) {
    }

    public function getInteger(ID $name, string $themeId): int
    {
        $fieldType = FieldType::NUMBER;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        if ($this->isFloatString($encodedValue)) {
            throw new UnexpectedValueException('The queried configuration was found as a float, not an integer');
        }

        return (int)$this->shopSettingEncoder->decode($fieldType, $encodedValue);
    }

    public function getFloat(ID $name, string $themeId): float
    {
        $fieldType = FieldType::NUMBER;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        if (!$this->isFloatString($encodedValue)) {
            throw new UnexpectedValueException('The queried configuration was found as an integer, not a float');
        }
        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return (float)$value;
    }

    protected function isFloatString(string $number): bool
    {
        return is_numeric($number) && str_contains($number, '.') !== false;
    }

    public function getBoolean(ID $name, string $themeId): bool
    {
        $fieldType = FieldType::BOOLEAN;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return (bool)$value;
    }

    public function getString(ID $name, string $themeId): string
    {
        $fieldType = FieldType::STRING;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getSelect(ID $name, string $themeId): string
    {
        $fieldType = FieldType::SELECT;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        $value = $this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getCollection(ID $name, string $themeId): array
    {
        $fieldType = FieldType::ARRAY;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        $value = (array)$this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getAssocCollection(ID $name, string $themeId): array
    {
        $fieldType = FieldType::ASSOCIATIVE_ARRAY;
        $encodedValue = $this->getSettingValue($name, $fieldType, $themeId);

        $value = (array)$this->shopSettingEncoder->decode($fieldType, $encodedValue);

        return $value;
    }

    public function getSettingsList(string $themeId): array
    {
        return $this->getSettingTypes($themeId);
    }

    public function saveIntegerSetting(ID $name, int $value, string $themeId): void
    {
        $this->getInteger($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::NUMBER, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveFloatSetting(ID $name, float $value, string $themeId): void
    {
        $this->getFloat($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::NUMBER, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveBooleanSetting(ID $name, bool $value, string $themeId): void
    {
        $this->getBoolean($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::BOOLEAN, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveStringSetting(ID $name, string $value, string $themeId): void
    {
        $this->getString($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::STRING, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveSelectSetting(ID $name, string $value, string $themeId): void
    {
        $this->getSelect($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::SELECT, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveCollectionSetting(ID $name, array $value, string $themeId): void
    {
        $this->getCollection($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::ARRAY, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    public function saveAssocCollectionSetting(ID $name, array $value, string $themeId): void
    {
        $this->getAssocCollection($name, $themeId);

        $value = $this->shopSettingEncoder->encode(FieldType::ASSOCIATIVE_ARRAY, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }

    protected function getSettingValue(ID $name, string $fieldType, string $theme): string
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('c.oxvarvalue')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxvarname = :name')
            ->andWhere('c.oxvartype = :type')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                'module' => 'theme:' . $theme,
                'name' => $name->val(),
                'type' => $fieldType,
                'shopId' => $this->basicContext->getCurrentShopId(),
            ]);

        /** @var Result $result */
        $result = $queryBuilder->execute();
        $value = $result->fetchOne();

        if ($value === false) {
            throw new NoSettingsFoundForThemeException($theme);
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

        $queryBuilder->execute();

        $this->eventDispatcher->dispatch(
            new ThemeSettingChangedEvent(
                (string)$name,
                $shopId,
                $themeId
            )
        );
    }
}
