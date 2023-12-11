<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class ModuleSettingController
{
    public function __construct(
        private ModuleSettingServiceInterface $moduleSettingService
    ) {
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingInteger(string $name, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingService->getIntegerSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingFloat(string $name, string $moduleId): FloatSetting
    {
        return $this->moduleSettingService->getFloatSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingBoolean(string $name, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingService->getBooleanSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingString(string $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->getStringSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingCollection(string $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->getCollectionSetting($name, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingInteger(string $name, int $value, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingService->changeIntegerSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingFloat(string $name, float $value, string $moduleId): FloatSetting
    {
        return $this->moduleSettingService->changeFloatSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingBoolean(string $name, bool $value, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingService->changeBooleanSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingString(string $name, string $value, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->changeStringSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingCollection(string $name, string $value, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->changeCollectionSetting($name, $value, $moduleId);
    }

    /**
     * @return SettingType[]
     */
    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingsList(string $moduleId): array
    {
        return $this->moduleSettingService->getSettingsList($moduleId);
    }
}
