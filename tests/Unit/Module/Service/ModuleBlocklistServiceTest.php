<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Dao\ProjectYamlDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\DataObject\DIConfigWrapper;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleBlocklistService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleBlocklistService
 */
class ModuleBlocklistServiceTest extends TestCase
{
    /**
     * @dataProvider blockListDataProvider
     */
    public function testIsModuleBlocked(
        string $moduleId,
        bool $expectedResult
    ): void {
        $reflector = new \ReflectionClass(ModuleBlocklistService::class);
        $classFilePath = pathinfo($reflector->getFileName())['dirname'];
        $filePath = 'testFilePath.yaml';
        $expectedData = ['modules' => ['module1', 'module2']];

        $configWrapperMock = $this->createMock(DIConfigWrapper::class);
        $configWrapperMock
            ->method('getConfigAsArray')
            ->willReturn($expectedData);

        $projectYamlDaoMock = $this->createMock(ProjectYamlDaoInterface::class);
        $projectYamlDaoMock
            ->method('loadDIConfigFile')
            ->with($classFilePath . '/../' . $filePath)
            ->willReturn($configWrapperMock);

        $sut = $this->getSut(moduleBlockListPath: $filePath, projectYamlDao: $projectYamlDaoMock);
        $actualResult = $sut->isModuleBlocked(moduleId: $moduleId);

        $this->assertSame($expectedResult, $actualResult);
    }

    public static function blockListDataProvider(): \Generator
    {
        yield 'isModuleBlocked returns true if Module is in the BlockList' => [
            'moduleId' => 'module1',
            'expectedResult' => true
        ];

        yield 'isModuleBlocked returns false if Module is not in the BlockList' => [
            'moduleId' => 'unknownModuleId',
            'expectedResult' => false
        ];
    }

    private function getSut(
        string $moduleBlockListPath,
        ProjectYamlDaoInterface $projectYamlDao
    ): ModuleBlocklistService {
        return new ModuleBlocklistService(
            moduleBlocklistPath: $moduleBlockListPath,
            projectYamlDao: $projectYamlDao
        );
    }
}
