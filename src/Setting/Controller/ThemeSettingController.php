<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingController
{
    public function __construct(
        private ThemeSettingServiceInterface $settingService
    ){}

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingInteger(ID $name, string $themeId): IntegerSetting
    {
        return $this->settingService->getIntegerSetting($name, $themeId);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingFloat(ID $name, string $themeId): FloatSetting
    {
        return $this->settingService->getFloatSetting($name, $themeId);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingBoolean(ID $name, string $themeId): BooleanSetting
    {
        return $this->settingService->getBooleanSetting($name, $themeId);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingString(ID $name, string $themeId): StringSetting
    {
        return $this->settingService->getStringSetting($name, $themeId);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingSelect(ID $name, string $themeId): StringSetting
    {
        return $this->settingService->getSelectSetting($name, $themeId);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingCollection(ID $name, string $themeId): StringSetting
    {
        return $this->settingService->getCollectionSetting($name, $themeId);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getThemeSettingAssocCollection(ID $name, string $themeId): StringSetting
    {
        return $this->settingService->getAssocCollectionSetting($name, $themeId);
    }
}
