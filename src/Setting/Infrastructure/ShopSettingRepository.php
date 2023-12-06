<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use Doctrine\DBAL\Result;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForShopException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingTypeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingValueException;

final class ShopSettingRepository implements ShopSettingRepositoryInterface
{
    public function __construct(
        private BasicContextInterface $basicContext,
        private QueryBuilderFactoryInterface $queryBuilderFactory,
        protected ShopSettingEncoderInterface $shopSettingEncoder,
        protected ShopConfigurationSettingDaoInterface $configurationSettingDao,
    ) {
    }

    public function getInteger(string $name): int
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::NUMBER);

        $value = $setting->getValue();
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

    public function getFloat(string $name): float
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::NUMBER);

        $value = $setting->getValue();
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

    public function getBoolean(string $name): bool
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::BOOLEAN);

        return (bool)$setting->getValue();
    }

    public function getString(string $name): string
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::STRING);

        return (string)$setting->getValue();
    }

    public function getSelect(string $name): string
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::SELECT);

        return (string)$setting->getValue();
    }

    public function getCollection(string $name): array
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::ARRAY);

        return $this->getArrayFromSettingValue($setting);
    }

    public function getAssocCollection(string $name): array
    {
        $setting = $this->getShopSetting($name);
        $this->checkSettingType($setting, FieldType::ASSOCIATIVE_ARRAY);

        return $this->getArrayFromSettingValue($setting);
    }

    protected function getShopSetting(string $name): ShopConfigurationSetting
    {
        return $this->configurationSettingDao->get($name, $this->basicContext->getCurrentShopId());
    }

    public function getSettingsList(): array
    {
        $shopId = $this->basicContext->getCurrentShopId();

        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('c.oxvarname')
            ->addSelect('c.oxvartype')
            ->from('oxconfig', 'c')
            ->where('c.oxmodule = :module')
            ->andWhere('c.oxshopid = :shopId')
            ->setParameters([
                ':module' => '',
                ':shopId' => $shopId
            ]);

        /** @var Result $result */
        $result = $queryBuilder->execute();

        /** @var array<string,string> $value */
        $value = $result->fetchAllKeyValue();

        if ($value === []) {
            throw new NoSettingsFoundForShopException($shopId);
        }

        return $value;
    }

    /**
     * @throws WrongSettingTypeException
     */
    public function checkSettingType(ShopConfigurationSetting $value, string $requiredType): void
    {
        if ($value->getType() !== $requiredType) {
            throw new WrongSettingTypeException();
        }
    }

    /**
     * @throws WrongSettingValueException
     */
    public function getArrayFromSettingValue(ShopConfigurationSetting $setting): array
    {
        $value = $setting->getValue();

        if (!is_array($value)) {
            throw new WrongSettingValueException();
        }

        return $value;
    }

    public function saveIntegerSetting(string $name, int $value): void
    {
        $this->saveAsType(FieldType::NUMBER, $name, $value);
    }

    public function saveFloatSetting(string $name, float $value): void
    {
        $this->saveAsType(FieldType::NUMBER, $name, $value);
    }

    public function saveBooleanSetting(string $name, bool $value): void
    {
        $this->saveAsType(FieldType::BOOLEAN, $name, $value);
    }

    public function saveStringSetting(string $name, string $value): void
    {
        $this->saveAsType(FieldType::STRING, $name, $value);
    }

    public function saveSelectSetting(string $name, string $value): void
    {
        $this->saveAsType(FieldType::SELECT, $name, $value);
    }

    public function saveCollectionSetting(string $name, array $value): void
    {
        $this->saveAsType(FieldType::ARRAY, $name, $value);
    }

    public function saveAssocCollectionSetting(string $name, array $value): void
    {
        $this->saveAsType(FieldType::ASSOCIATIVE_ARRAY, $name, $value);
    }

    private function saveAsType(string $type, string $name, mixed $value): void
    {
        $this->validateOriginalSettingType($name, $type);

        $setting = (new ShopConfigurationSetting())
            ->setShopId($this->basicContext->getCurrentShopId())
            ->setName($name)
            ->setType($type)
            ->setValue($value);

        $this->configurationSettingDao->save($setting);
    }

    private function validateOriginalSettingType(string $originalSettingName, string $type): void
    {
        $originalSetting = $this->getShopSetting($originalSettingName);
        if ($originalSetting->getType() !== $type) {
            throw new WrongSettingTypeException();
        }
    }
}
