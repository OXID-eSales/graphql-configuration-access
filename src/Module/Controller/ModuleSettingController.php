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

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
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
    public function moduleSettingBoolean(string $name, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingService->getBooleanSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingCollection(string $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->getCollectionSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingFloat(string $name, string $moduleId): FloatSetting
    {
        return $this->moduleSettingService->getFloatSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingInteger(string $name, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingService->getIntegerSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingString(string $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->getStringSetting($name, $moduleId);
    }

    /**
     * @return SettingType[]
     */
    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettings(string $moduleId): array
    {
        return $this->moduleSettingService->getSettingsList($moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingBooleanChange(string $name, bool $value, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingService->changeBooleanSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingCollectionChange(string $name, string $value, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->changeCollectionSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingFloatChange(string $name, float $value, string $moduleId): FloatSetting
    {
        return $this->moduleSettingService->changeFloatSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingIntegerChange(string $name, int $value, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingService->changeIntegerSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function moduleSettingStringChange(string $name, string $value, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->changeStringSetting($name, $value, $moduleId);
    }
}
