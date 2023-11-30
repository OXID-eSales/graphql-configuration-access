<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;

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
    public function getThemeSettingInteger(ID $name, string $themeId): IntegerSetting
    {
        return $this->themeSettingService->getIntegerSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getThemeSettingFloat(ID $name, string $themeId): FloatSetting
    {
        return $this->themeSettingService->getFloatSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getThemeSettingBoolean(ID $name, string $themeId): BooleanSetting
    {
        return $this->themeSettingService->getBooleanSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getThemeSettingString(ID $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getStringSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getThemeSettingSelect(ID $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getSelectSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getThemeSettingCollection(ID $name, string $themeId): StringSetting
    {
        return $this->themeSettingService->getCollectionSetting($name, $themeId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getThemeSettingAssocCollection(ID $name, string $themeId): StringSetting
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
    public function getThemeSettingsList(string $themeId): array
    {
        return $this->themeSettingService->getSettingsList($themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingInteger(ID $name, int $value, string $themeId): IntegerSetting
    {
        return $this->themeSettingService->changeIntegerSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingFloat(ID $name, float $value, string $themeId): FloatSetting
    {
        return $this->themeSettingService->changeFloatSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingBoolean(ID $name, bool $value, string $themeId): BooleanSetting
    {
        return $this->themeSettingService->changeBooleanSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingString(ID $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeStringSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingSelect(ID $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeSelectSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingCollection(ID $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeCollectionSetting($name, $value, $themeId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeThemeSettingAssocCollection(ID $name, string $value, string $themeId): StringSetting
    {
        return $this->themeSettingService->changeAssocCollectionSetting($name, $value, $themeId);
    }
}
