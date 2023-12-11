<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Theme\Event\ThemeSettingChangedEvent;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\NoSettingsFoundForThemeException;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\WrongSettingValueException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ThemeSettingRepository implements ThemeSettingRepositoryInterface
{
    public function __construct(
        private BasicContextInterface $basicContext,
        private EventDispatcherInterface $eventDispatcher,
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        protected ShopSettingEncoderInterface $shopSettingEncoder
    ) {
    }

    public function getInteger(string $name, string $themeId): int
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER, $themeId);

        if (
            !is_int($value)
            && !(is_string($value) && $this->matchesOnlyDigits($value))
        ) {
            throw new WrongSettingValueException();
        }

        return (int)$value;
    }

    private function matchesOnlyDigits(string $value): bool
    {
        return (bool)preg_match("/^\d+$/", $value);
    }

    public function getFloat(string $name, string $themeId): float
    {
        $value = $this->getSettingValue($name, FieldType::NUMBER, $themeId);

        if (
            !is_int($value)
            && !is_float($value)
            && !(is_string($value) && $this->matchesFloatDigits($value))
        ) {
            throw new WrongSettingValueException();
        }

        return (float)$value;
    }

    private function matchesFloatDigits(string $value): bool
    {
        return (bool)preg_match("/^\d+(\.\d+)?$/", $value);
    }

    public function getBoolean(string $name, string $themeId): bool
    {
        $value = $this->getSettingValue($name, FieldType::BOOLEAN, $themeId);

        return (bool)$value;
    }

    public function getString(string $name, string $themeId): string
    {
        $value = $this->getSettingValue($name, FieldType::STRING, $themeId);

        return (string)$value;
    }

    public function getSelect(string $name, string $themeId): string
    {
        $value = $this->getSettingValue($name, FieldType::SELECT, $themeId);

        return (string)$value;
    }

    public function getCollection(string $name, string $themeId): array
    {
        $value = $this->getSettingValue($name, FieldType::ARRAY, $themeId);

        return $this->getArrayFromSettingValue($value);
    }

    public function getAssocCollection(string $name, string $themeId): array
    {
        $fieldType = FieldType::ASSOCIATIVE_ARRAY;
        $value = $this->getSettingValue($name, $fieldType, $themeId);

        return $this->getArrayFromSettingValue($value);
    }

    /**
     * @throws WrongSettingValueException
     */
    public function getArrayFromSettingValue(mixed $value): array
    {
        if (!is_array($value)) {
            throw new WrongSettingValueException();
        }

        return $value;
    }

    public function getSettingsList(string $themeId): array
    {
        $themeCondition = (!empty($themeId)) ? 'theme:' . $themeId : '';
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

        /** @var array<string, string> $value */
        $value = $result->fetchAllKeyValue();

        if ($value === []) {
            throw new NoSettingsFoundForThemeException($themeId);
        }

        return $value;
    }

    public function saveIntegerSetting(string $name, int $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::NUMBER, $name, $themeId, $value);
    }

    public function saveFloatSetting(string $name, float $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::NUMBER, $name, $themeId, $value);
    }

    public function saveBooleanSetting(string $name, bool $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::BOOLEAN, $name, $themeId, $value);
    }

    public function saveStringSetting(string $name, string $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::STRING, $name, $themeId, $value);
    }

    public function saveSelectSetting(string $name, string $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::SELECT, $name, $themeId, $value);
    }

    public function saveCollectionSetting(string $name, array $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::ARRAY, $name, $themeId, $value);
    }

    public function saveAssocCollectionSetting(string $name, array $value, string $themeId): void
    {
        $this->saveSettingAsType(FieldType::ASSOCIATIVE_ARRAY, $name, $themeId, $value);
    }

    /**
     * @throws NoSettingsFoundForThemeException
     */
    protected function getSettingValue(string $name, string $fieldType, string $theme): mixed
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
                'name' => $name,
                'type' => $fieldType,
                'shopId' => $this->basicContext->getCurrentShopId(),
            ]);

        /** @var Result $result */
        $result = $queryBuilder->execute();
        $value = $result->fetchOne();

        if ($value === false) {
            throw new NoSettingsFoundForThemeException($theme);
        }

        return $this->shopSettingEncoder->decode($fieldType, $value);
    }

    protected function saveSettingValue(string $name, string $themeId, string $value): void
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
                'name' => $name,
                'themeId' => 'theme:' . $themeId,
                'value' => $value
            ]);

        $queryBuilder->execute();

        $this->eventDispatcher->dispatch(
            new ThemeSettingChangedEvent(
                $name,
                $shopId,
                $themeId
            )
        );
    }

    protected function saveSettingAsType(string $settingType, string $name, string $themeId, mixed $value): void
    {
        $this->getSettingValue($name, $settingType, $themeId);

        $value = $this->shopSettingEncoder->encode($settingType, $value);

        $this->saveSettingValue($name, $themeId, (string)$value);
    }
}
