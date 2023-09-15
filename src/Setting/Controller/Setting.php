<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\Setting as SettingAliasDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\Setting as SettingService;
use TheCodingMachine\GraphQLite\Annotations\HideIfUnauthorized;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class Setting
{
    public function __construct(
        private SettingService $settingService
    ){}

    /**
     * @Query
     * @Logged()
     * @HideIfUnauthorized()
     * @Right("CHANGE_CONFIGURATION")
     */
    public function getSetting (string $name): SettingAliasDataType
    {
        return $this->settingService->getSetting($name);
    }

}
