<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\YamlFileLoaderInfrastructureInterface;
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
        $filePath = 'testFilePath.yaml';
        $expectedData = ['modules' => ['module1', 'module2']];

        $yamlFileLoaderMock = $this->createMock(YamlFileLoaderInfrastructureInterface::class);
        $yamlFileLoaderMock
            ->method('load')
            ->with($this->stringContains($filePath))
            ->willReturn($expectedData);

        $sut = $this->getSut(moduleBlockList: $filePath, yamlFileLoader: $yamlFileLoaderMock);
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

    public function testGetModuleBlocklistThrowsExceptionOnFailure(): void
    {
        $moduleId = uniqid();
        $yamlFileLoaderMock = $this->createMock(YamlFileLoaderInfrastructureInterface::class);
        $yamlFileLoaderMock
            ->method('load')
            ->will($this->throwException(new \Exception('Failed to load YAML file')));

        $this->expectException(ModuleBlockListException::class);

        $sut = $this->getSut(yamlFileLoader: $yamlFileLoaderMock);
        $sut->isModuleBlocked(moduleId: $moduleId);
    }

    private function getSut(
        string $moduleBlockList = null,
        YamlFileLoaderInfrastructureInterface $yamlFileLoader = null
    ): ModuleBlocklistService {
        return new ModuleBlocklistService(
            moduleBlocklist: $moduleBlockList
            ?? 'testFilePath.yaml',
            yamlFileLoader: $yamlFileLoader
            ?? $this->createStub(YamlFileLoaderInfrastructureInterface::class)
        );
    }
}
