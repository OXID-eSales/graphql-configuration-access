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
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingRepository implements ModuleSettingRepositoryInterface
{
    public function __construct(
        private ModuleSettingServiceInterface $moduleSettingService,
        private ModuleConfigurationDaoInterface $moduleConfigurationDao,
        private BasicContextInterface $basicContext
    ) {
    }

    public function getIntegerSetting(string $name, string $moduleId): int
    {
        return $this->moduleSettingService->getInteger($name, $moduleId);
    }

    public function getFloatSetting(string $name, string $moduleId): float
    {
        return $this->moduleSettingService->getFloat($name, $moduleId);
    }

    public function getBooleanSetting(string $name, string $moduleId): bool
    {
        return $this->moduleSettingService->getBoolean($name, $moduleId);
    }

    public function getStringSetting(string $name, string $moduleId): string
    {
        return (string)$this->moduleSettingService->getString($name, $moduleId);
    }

    public function getCollectionSetting(string $name, string $moduleId): array
    {
        return $this->moduleSettingService->getCollection($name, $moduleId);
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
