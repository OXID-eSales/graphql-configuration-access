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
        private ShopSettingServiceInterface $shopSettingService
    ) {
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingInteger(ID $name): IntegerSetting
    {
        return $this->shopSettingService->getIntegerSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingFloat(ID $name): FloatSetting
    {
        return $this->shopSettingService->getFloatSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingBoolean(ID $name): BooleanSetting
    {
        return $this->shopSettingService->getBooleanSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingString(ID $name): StringSetting
    {
        return $this->shopSettingService->getStringSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingSelect(ID $name): StringSetting
    {
        return $this->shopSettingService->getSelectSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingCollection(ID $name): StringSetting
    {
        return $this->shopSettingService->getCollectionSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingAssocCollection(ID $name): StringSetting
    {
        return $this->shopSettingService->getAssocCollectionSetting($name);
    }

    /**
     * @return SettingType[]
     */
    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingsList(): array
    {
        return $this->shopSettingService->getSettingsList();
    }
}
