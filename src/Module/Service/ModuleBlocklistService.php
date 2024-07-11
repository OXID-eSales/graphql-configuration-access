<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\YamlFileLoaderInfrastructureInterface;

class ModuleBlocklistService implements ModuleBlocklistServiceInterface
{
    public function __construct(
        private readonly string $moduleBlocklist,
        private readonly YamlFileLoaderInfrastructureInterface $yamlFileLoader
    ) {
    }

    /**
     * @inheritDoc
     */
    public function isModuleBlocked(string $moduleId): bool
    {
        try {
            $resolvedPath = dirname(__FILE__) . '/' . $this->moduleBlocklist;
            $blocklistData = $this->yamlFileLoader->load($resolvedPath);

            return in_array($moduleId, $blocklistData['modules'], true);
        } catch (\Exception $e) {
            throw new ModuleBlockListException();
        }
    }
}
