<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;

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
    public function getModuleSettingInteger(ID $name, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingService->getIntegerSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingFloat(ID $name, string $moduleId): FloatSetting
    {
        return $this->moduleSettingService->getFloatSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingBoolean(ID $name, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingService->getBooleanSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingString(ID $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->getStringSetting($name, $moduleId);
    }

    #[Query]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function getModuleSettingCollection(ID $name, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->getCollectionSetting($name, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingInteger(ID $name, int $value, string $moduleId): IntegerSetting
    {
        return $this->moduleSettingService->changeIntegerSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingFloat(ID $name, float $value, string $moduleId): FloatSetting
    {
        return $this->moduleSettingService->changeFloatSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingBoolean(ID $name, bool $value, string $moduleId): BooleanSetting
    {
        return $this->moduleSettingService->changeBooleanSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingString(ID $name, string $value, string $moduleId): StringSetting
    {
        return $this->moduleSettingService->changeStringSetting($name, $value, $moduleId);
    }

    #[Mutation]
    #[Logged]
    #[HideIfUnauthorized]
    #[Right('CHANGE_CONFIGURATION')]
    public function changeModuleSettingCollection(ID $name, string $value, string $moduleId): StringSetting
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
