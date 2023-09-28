<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ModuleSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class SettingService implements SettingServiceInterface
{

    public function __construct(
        private ModuleSettingRepository $moduleSettingRepository
    ) {}

    public function getModuleIntegerSetting(ID $name, $moduleId): IntegerSetting
    {
        return $this->moduleSettingRepository->getIntegerSetting($name, $moduleId);
    }
}
