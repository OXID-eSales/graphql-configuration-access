<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Dao\ProjectYamlDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\DataObject\DIConfigWrapper;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\YamlFileLoaderInfrastructure;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\YamlFileLoaderInfrastructureInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\YamlFileLoaderInfrastructure
 */
class YamlFileLoaderInfrastructureTest extends TestCase
{
    public function testLoaderReturnsData(): void
    {
        $filePath = 'testFile.yaml';
        $expectedData = ['modules' => ['module1', 'module2']];
        $configWrapperMock = $this->createMock(DIConfigWrapper::class);
        $configWrapperMock
            ->method('getConfigAsArray')
            ->willReturn($expectedData);

        $projectYamlDaoMock = $this->createMock(ProjectYamlDaoInterface::class);
        $projectYamlDaoMock
            ->method('loadDIConfigFile')
            ->with($filePath)
            ->willReturn($configWrapperMock);

        $sut = $this->getSut(projectYamlDao: $projectYamlDaoMock);
        $actualResult = $sut->load($filePath);

        $this->assertSame($expectedData, $actualResult);
    }

    public function testLoaderThrowsException(): void
    {
        $filePath = 'testFile.yaml';
        $projectYamlDaoMock = $this->createMock(ProjectYamlDaoInterface::class);
        $projectYamlDaoMock
            ->method('loadDIConfigFile')
            ->with($filePath)
            ->willThrowException(new \Exception());

        $this->expectException(ModuleBlockListException::class);

        $sut = $this->getSut(projectYamlDao: $projectYamlDaoMock);
        $sut->load($filePath);
    }

    private function getSut(
        ProjectYamlDaoInterface $projectYamlDao = null
    ): YamlFileLoaderInfrastructure {
        return new YamlFileLoaderInfrastructure(
            projectYamlDao: $projectYamlDao
            ?? $this->createStub(YamlFileLoaderInfrastructureInterface::class),
        );
    }
}
