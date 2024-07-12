<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;

interface YamlFileLoaderInfrastructureInterface
{
    /**
     * @return array
     * @throws ModuleBlockListException
     */
    public function load(string $filePath): array;
}
