<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;

final class ShopSettingController
{
    public function __construct(
        private ShopSettingServiceInterface $settingService
    ) {
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingInteger(ID $name): IntegerSetting
    {
        return $this->settingService->getIntegerSetting($name);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingFloat(ID $name): FloatSetting
    {
        return $this->settingService->getFloatSetting($name);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingBoolean(ID $name): BooleanSetting
    {
        return $this->settingService->getBooleanSetting($name);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingString(ID $name): StringSetting
    {
        return $this->settingService->getStringSetting($name);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingSelect(ID $name): StringSetting
    {
        return $this->settingService->getSelectSetting($name);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingCollection(ID $name): StringSetting
    {
        return $this->settingService->getCollectionSetting($name);
    }

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getShopSettingAssocCollection(ID $name): StringSetting
    {
        return $this->settingService->getAssocCollectionSetting($name);
    }

    /**
     * @Query
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     * @return SettingType[]
     */
    public function getShopSettingsList(): array
    {
        return $this->settingService->getSettingsList();
    }
}
