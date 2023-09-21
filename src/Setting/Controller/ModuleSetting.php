<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSetting as ModuleSettingService;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;


final class ModuleSetting
{
    public function __construct(
        private ModuleSettingService $settingService
    ){}

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
    public function changeModuleSettingFloat(ID $name, bool $value, string $moduleId): FloatSetting
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
