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

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingAssocCollection(string $name): StringSetting
    {
        return $this->shopSettingService->getAssocCollectionSetting($name);
    }

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingBoolean(string $name): BooleanSetting
    {
        return $this->shopSettingService->getBooleanSetting($name);
    }

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingCollection(string $name): StringSetting
    {
        return $this->shopSettingService->getCollectionSetting($name);
    }

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingFloat(string $name): FloatSetting
    {
        return $this->shopSettingService->getFloatSetting($name);
    }

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingInteger(string $name): IntegerSetting
    {
        return $this->shopSettingService->getIntegerSetting($name);
    }

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingSelect(string $name): StringSetting
    {
        return $this->shopSettingService->getSelectSetting($name);
    }

    /**
     * Query of Configuration Access Module
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingString(string $name): StringSetting
    {
        return $this->shopSettingService->getStringSetting($name);
    }

    /**
     * Query of Configuration Access Module
     * @return SettingType[]
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettings(): array
    {
        return $this->shopSettingService->getSettingsList();
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingAssocCollectionChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeAssocCollectionSetting($name, $value);
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingBooleanChange(string $name, bool $value): BooleanSetting
    {
        return $this->shopSettingService->changeBooleanSetting($name, $value);
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingCollectionChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeCollectionSetting($name, $value);
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingFloatChange(string $name, float $value): FloatSetting
    {
        return $this->shopSettingService->changeFloatSetting($name, $value);
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingIntegerChange(string $name, int $value): IntegerSetting
    {
        return $this->shopSettingService->changeIntegerSetting($name, $value);
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingSelectChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeSelectSetting($name, $value);
    }

    /**
     * Mutation of Configuration Access Module
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function shopSettingStringChange(string $name, string $value): StringSetting
    {
        return $this->shopSettingService->changeStringSetting($name, $value);
    }
}
