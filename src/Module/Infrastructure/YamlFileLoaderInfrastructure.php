<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Dao\ProjectYamlDaoInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;

class YamlFileLoaderInfrastructure implements YamlFileLoaderInfrastructureInterface
{
    public function __construct(
        private readonly ProjectYamlDaoInterface $projectYamlDao
    ) {
    }

    public function load(string $filePath): array
    {
        try {
            $configWrapper = $this->projectYamlDao->loadDIConfigFile($filePath);
            $yamlData = $configWrapper->getConfigAsArray();
        } catch (\Exception $e) {
            throw new ModuleBlockListException();
        }

        return $yamlData;
    }
}
