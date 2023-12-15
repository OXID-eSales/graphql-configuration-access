<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class ThemeSettingController
{
    public function __construct(
        private ThemeSettingServiceInterface $themeSettingService
    ) {
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingInteger(string $name, string $themeId): IntegerSetting
    {
        return $this->themeSettingService->getIntegerSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingFloat(string $name, string $themeId): FloatSetting
    {
        return $this->themeSettingService->getFloatSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingBoolean(string $name, string $themeId): BooleanSetting
    {
        return $this->themeSettingService->getBooleanSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingString(string $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getStringSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingSelect(string $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getSelectSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingCollection(string $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getCollectionSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingAssocCollection(string $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getAssocCollectionSetting($name, $themeId);
    }

    /**
     * @return SettingType[]
     */
    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettings(string $themeId): array
    {
        return $this->themeSettingService->getSettingsList($themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingIntegerChange(string $name, int $value, string $themeId): IntegerSetting
    {
        return $this->themeSettingService->changeIntegerSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingFloatChange(string $name, float $value, string $themeId): FloatSetting
    {
        return $this->themeSettingService->changeFloatSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingBooleanChange(string $name, bool $value, string $themeId): BooleanSetting
    {
        return $this->themeSettingService->changeBooleanSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingStringChange(string $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeStringSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingSelectChange(string $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeSelectSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingCollectionChange(string $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeCollectionSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function themeSettingAssocCollectionChange(string $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeAssocCollectionSetting($name, $value, $themeId);
    }
}
