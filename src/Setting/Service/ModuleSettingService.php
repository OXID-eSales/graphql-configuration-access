<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepositoryInterface;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingService implements ModuleSettingServiceInterface
{
    public function __construct(
        private ContextInterface $context,
        private ModuleConfigurationDaoInterface $moduleConfigurationDao,
        private ModuleSettingRepositoryInterface $moduleSettingRepository
    ) {}

    public function getIntegerSetting(ID $name, $moduleId): IntegerSetting
    {
        return $this->moduleSettingRepository->getIntegerSetting($name, $moduleId);
    }

    public function getFloatSetting(ID $name, $moduleId): FloatSetting
    {
        return $this->moduleSettingRepository->getFloatSetting($name, $moduleId);
    }

    public function getBooleanSetting(ID $name, $moduleId): BooleanSetting
    {
        return $this->moduleSettingRepository->getBooleanSetting($name, $moduleId);
    }

    public function getStringSetting(ID $name, $moduleId): StringSetting
    {
        return $this->moduleSettingRepository->getStringSetting($name, $moduleId);
    }

    public function getCollectionSetting(ID $name, $moduleId): StringSetting
    {
        return $this->moduleSettingRepository->getCollectionSetting($name, $moduleId);
    }

    public function changeIntegerSetting(ID $name, int $value, string $moduleId): IntegerSetting
    {
        $settingType = $this->getSettingType($name, $moduleId);
        if ($settingType !== FieldType::NUMBER) {
            throw new InvalidType($settingType);
        }

        $this->moduleSettingRepository->saveIntegerSetting($name, $value, $moduleId);

        return new IntegerSetting($name, $value);
    }

    public function changeFloatSetting(ID $name, float $value, string $moduleId): FloatSetting
    {
        $settingType = $this->getSettingType($name, $moduleId);
        if ($settingType !== FieldType::NUMBER) {
            throw new InvalidType($settingType);
        }

        $this->moduleSettingRepository->saveFloatSetting($name, $value, $moduleId);

        return new FloatSetting($name, $value);
    }

    public function changeBooleanSetting(ID $name, bool $value, string $moduleId): BooleanSetting
    {
        $settingType = $this->getSettingType($name, $moduleId);
        if ($settingType !== FieldType::BOOLEAN) {
            throw new InvalidType($settingType);
        }

        $this->moduleSettingRepository->saveBooleanSetting($name, $value, $moduleId);

        return new BooleanSetting($name, $value);
    }

    public function changeStringSetting(ID $name, string $value, string $moduleId): StringSetting
    {
        $settingType = $this->getSettingType($name, $moduleId);
        if (!in_array($settingType, [FieldType::STRING, FieldType::SELECT])) {
            throw new InvalidType($settingType);
        }

        $this->moduleSettingRepository->saveStringSetting($name, $value, $moduleId);

        return new StringSetting($name, $value);
    }

    public function changeCollectionSetting(ID $name, string $value, string $moduleId): StringSetting
    {
        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollection($value);
        }

        $this->moduleSettingRepository->saveCollectionSetting($name, $arrayValue, $moduleId);

        return new StringSetting($name, $value);
    }

    protected function getSettingType(ID $name, string $moduleId): string
    {
        $shopId = $this->context->getCurrentShopId();
        $moduleConfiguration = $this->moduleConfigurationDao->get($moduleId, $shopId);
        $setting = $moduleConfiguration->getModuleSetting((string) $name);

        return $setting->getType();
    }
}
