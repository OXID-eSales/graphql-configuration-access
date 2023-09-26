<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleRepository
{
    public function __construct(
//        private ModuleConfigurationDaoInterface $moduleConfigurationDao,
        private ModuleSettingServiceInterface $moduleSettingService,
//        private ContextInterface $context
    ) {}

    public function getIntegerSetting(ID $name, string $moduleId):IntegerSetting
    {
        $value = $this->moduleSettingService->getInteger($name->val(), $moduleId);
        var_dump($value);
    }
}
