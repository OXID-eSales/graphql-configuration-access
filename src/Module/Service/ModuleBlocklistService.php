<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Dao\ProjectYamlDaoInterface;

class ModuleBlocklistService implements ModuleBlocklistServiceInterface
{
    public function __construct(
        private readonly string $moduleBlocklistPath,
        private readonly ProjectYamlDaoInterface $projectYamlDao
    ) {
    }

    public function isModuleBlocked(string $moduleId): bool
    {
        $resolvedPath = dirname(__FILE__) . '/../' . $this->moduleBlocklistPath;
        $configWrapper = $this->projectYamlDao->loadDIConfigFile($resolvedPath);
        $blocklistData = $configWrapper->getConfigAsArray();

        return in_array($moduleId, $blocklistData['modules'], true);
    }
}
