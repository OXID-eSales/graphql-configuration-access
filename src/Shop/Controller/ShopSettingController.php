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

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
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
    public function shopSettingAssocCollection(string $name): StringSetting
    {
        return $this->shopSettingService->getAssocCollectionSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingBoolean(string $name): BooleanSetting
    {
        return $this->shopSettingService->getBooleanSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingCollection(string $name): StringSetting
    {
        return $this->shopSettingService->getCollectionSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingFloat(string $name): FloatSetting
    {
        return $this->shopSettingService->getFloatSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingInteger(string $name): IntegerSetting
    {
        return $this->shopSettingService->getIntegerSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingSelect(string $name): StringSetting
    {
        return $this->shopSettingService->getSelectSetting($name);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingString(string $name): StringSetting
    {
        return $this->shopSettingService->getStringSetting($name);
    }

    /**
     * @return SettingType[]
     */
    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettings(): array
    {
        return $this->shopSettingService->getSettingsList();
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingAssocCollectionChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeAssocCollectionSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingBooleanChange(string $name, bool $value): BooleanSetting
    {
        return $this->shopSettingService->changeBooleanSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingCollectionChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeCollectionSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingFloatChange(string $name, float $value): FloatSetting
    {
        return $this->shopSettingService->changeFloatSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingIntegerChange(string $name, int $value): IntegerSetting
    {
        return $this->shopSettingService->changeIntegerSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingSelectChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeSelectSetting($name, $value);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingStringChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeStringSetting($name, $value);
    }
}
