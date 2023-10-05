<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleSettingRepository implements ModuleSettingRepositoryInterface
{
    public function __construct(
        private ModuleSettingServiceInterface $moduleSettingService
    ) {}

    public function getIntegerSetting(ID $name, string $moduleId): IntegerSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getInteger($name, $moduleId);

        return new IntegerSetting($name, '', $value);
    }

    public function getFloatSetting(ID $name, string $moduleId): FloatSetting
    {
        $name = $name->val();
        $value = $this->moduleSettingService->getFloat($name, $moduleId);

        return new FloatSetting($name, '', $value);
    }
}
