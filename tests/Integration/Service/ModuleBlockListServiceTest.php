<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Dao\ProjectYamlDaoInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleBlocklistService;
use Symfony\Component\Yaml\Yaml;

class ModuleBlockListServiceTest extends IntegrationTestCase
{
    public function testLoadYamlList(): void
    {
        $moduleServices = Yaml::parseFile(dirname(__FILE__) . '/../../../src/Module/services.yaml');
        $blockedListYamlPathParameterName = 'oxidesales.graphqlconfigurationaccess.modules_block_list_path';
        $blockedListYamlPath = $moduleServices['parameters'][$blockedListYamlPathParameterName];

        $sut = new ModuleBlocklistService(
            moduleBlocklistPath: $blockedListYamlPath,
            projectYamlDao: $this->get(ProjectYamlDaoInterface::class)
        );

        $this->assertTrue($sut->isModuleBlocked('oe_graphql_base'));
        $this->assertTrue($sut->isModuleBlocked('oe_graphql_configuration_access'));
    }
}
