<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingRepository implements ModuleSettingRepositoryInterface
{
    public function __construct(
        private ModuleSettingServiceInterface $moduleSettingService,
        private ModuleConfigurationDaoInterface $moduleConfigurationDao,
        private BasicContextInterface $basicContext
    ) {
    }

    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getInteger($name, $moduleId);

        return new IntegerSetting(new ID($name), $value);
    }

    public function getFloatSetting(ID $name, string $moduleId): FloatSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getFloat($name, $moduleId);

        return new FloatSetting(new ID($name), $value);
    }

    public function getBooleanSetting(ID $name, string $moduleId): BooleanSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getBoolean($name, $moduleId);

        return new BooleanSetting(new ID($name), $value);
    }

    public function getStringSetting(ID $name, string $moduleId): StringSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getString($name, $moduleId);

        return new StringSetting(new ID($name), (string)$value);
    }

    public function getCollectionSetting(ID $name, string $moduleId): StringSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getCollection($name, $moduleId);

        return new StringSetting(new ID($name), json_encode($value));
    }

    public function saveIntegerSetting(ID $name, int $value, string $moduleId): void
    {
        $this->moduleSettingService->saveInteger($name->val(), $value, $moduleId);
    }

    public function saveFloatSetting(ID $name, float $value, string $moduleId): void
    {
        $this->moduleSettingService->saveFloat($name->val(), $value, $moduleId);
    }

    public function saveBooleanSetting(ID $name, bool $value, string $moduleId): void
    {
        $this->moduleSettingService->saveBoolean($name->val(), $value, $moduleId);
    }

    public function saveStringSetting(ID $name, string $value, string $moduleId): void
    {
        $this->moduleSettingService->saveString($name->val(), $value, $moduleId);
    }

    public function saveCollectionSetting(ID $name, array $value, string $moduleId): void
    {
        $this->moduleSettingService->saveCollection($name->val(), $value, $moduleId);
    }

    /**
     * @return Setting[]
     */
    public function getSettingsList(string $moduleId): array
    {
        $moduleConfiguration = $this->moduleConfigurationDao->get($moduleId, $this->basicContext->getCurrentShopId());
        return $moduleConfiguration->getModuleSettings();
    }
}
