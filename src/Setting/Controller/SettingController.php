<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\SettingServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;

final class SettingController
{
    public function __construct(
        private SettingServiceInterface $settingService
    ){}

    /**
     * @Query()
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getModuleSettingInteger(ID $name, string $moduleId): IntegerSetting
    {
        return $this->settingService->getModuleIntegerSetting($name, $moduleId);
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
}
