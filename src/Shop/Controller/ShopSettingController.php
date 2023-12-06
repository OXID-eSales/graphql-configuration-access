<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shop\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Service\ShopSettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

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
    public function getShopSettingInteger(string $name): IntegerSetting
    {
        return $this->shopSettingService->getIntegerSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingFloat(string $name): FloatSetting
    {
        return $this->shopSettingService->getFloatSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingBoolean(string $name): BooleanSetting
    {
        return $this->shopSettingService->getBooleanSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingString(string $name): StringSetting
    {
        return $this->shopSettingService->getStringSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingSelect(string $name): StringSetting
    {
        return $this->shopSettingService->getSelectSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingCollection(string $name): StringSetting
    {
        return $this->shopSettingService->getCollectionSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getShopSettingAssocCollection(string $name): StringSetting
    {
        return $this->shopSettingService->getAssocCollectionSetting($name);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingInteger(string $name, int $value): IntegerSetting
    {
        return $this->shopSettingService->changeIntegerSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingFloat(string $name, float $value): FloatSetting
    {
        return $this->shopSettingService->changeFloatSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingBoolean(string $name, bool $value): BooleanSetting
    {
        return $this->shopSettingService->changeBooleanSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingString(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeStringSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingSelect(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeSelectSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingCollection(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeCollectionSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeShopSettingAssocCollection(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeAssocCollectionSetting($name, $value);
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
