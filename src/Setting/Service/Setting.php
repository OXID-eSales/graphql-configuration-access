<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Basket\Infrastructure\ModuleRepository as ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class Setting
{

    public function __construct(
        private ModuleSettingRepository $moduleSettingRepository
    ) {}

    public function getModuleIntegerSetting(ID $name, $moduleId):IntegerSetting
    {
        $this->moduleSettingRepository->getIntegerSetting($name, $moduleId);
    }
}
