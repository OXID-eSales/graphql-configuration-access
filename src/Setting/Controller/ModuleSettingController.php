<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
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
        private ModuleSettingServiceInterface $settingService
    ){}

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getModuleSettingInteger(ID $name, string $moduleId): IntegerSetting
    {
        return $this->settingService->getIntegerSetting($name, $moduleId);
    }

    /**
     * @Query
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getModuleSettingFloat(ID $name, string $moduleId): FloatSetting
    {
        return $this->settingService->getFloatSetting($name, $moduleId);
    }

    /**
     * @Query
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getModuleSettingBoolean(ID $name, string $moduleId): BooleanSetting
    {
        return $this->settingService->getBooleanSetting($name, $moduleId);
    }

    /**
     * @Query
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getModuleSettingString(ID $name, string $moduleId): StringSetting
    {
        return $this->settingService->getStringSetting($name, $moduleId);
    }

    /**
     * @Query
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getModuleSettingCollection(ID $name, string $moduleId): StringSetting
    {
        return $this->settingService->getCollectionSetting($name, $moduleId);
    }

    /**
     * @Mutation
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function changeModuleSettingInteger(ID $name, int $value, string $moduleId): IntegerSetting
    {
        return $this->settingService->changeIntegerSetting($name, $value, $moduleId);
    }

    /**
     * @Mutation
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function changeModuleSettingFloat(ID $name, float $value, string $moduleId): FloatSetting
    {
        return $this->settingService->changeFloatSetting($name, $value, $moduleId);
    }

    /**
     * @Mutation
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function changeModuleSettingBoolean(ID $name, bool $value, string $moduleId): BooleanSetting
    {
        return $this->settingService->changeBooleanSetting($name, $value, $moduleId);
    }

    /**
     * @Mutation
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function changeModuleSettingString(ID $name, string $value, string $moduleId): StringSetting
    {
        return $this->settingService->changeStringSetting($name, $value, $moduleId);
    }
}
