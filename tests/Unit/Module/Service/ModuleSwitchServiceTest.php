<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure\ModuleSwitchInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSwitchService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSwitchService
 */
class ModuleSwitchServiceTest extends TestCase
{
    /**
     * @dataProvider activationDataProvider
     */
    public function testModuleActivationAndDeactivation(
        string $method,
        string $moduleId
    ): void {
        $moduleSwitchInfrastructureMock = $this->createMock(ModuleSwitchInfrastructureInterface::class);
        $moduleSwitchInfrastructureMock
            ->method($method)
            ->with($moduleId)
            ->willReturn(true);

        $sut = $this->getSut(moduleSwitchInfrastructure: $moduleSwitchInfrastructureMock);
        $actualResult = ($method == 'activateModule')
            ? $sut->activateModule(moduleId: $moduleId)
            : $sut->deactivateModule(moduleId: $moduleId);

        $this->assertTrue($actualResult);
    }

    private function getSut(
        ModuleSwitchInfrastructureInterface $moduleSwitchInfrastructure = null
    ): ModuleSwitchService {
        return new ModuleSwitchService(
            moduleSwitchInfrastructure: $moduleSwitchInfrastructure
                ?? $this->createStub(ModuleSwitchInfrastructureInterface::class)
        );
    }

    public static function activationDataProvider(): \Generator
    {
        yield 'test activate module' => [
            'method' => 'activateModule',
            'moduleId' => uniqid()
        ];

        yield 'test deactivate module' => [
            'method' => 'deactivateModule',
            'moduleId' => uniqid()
        ];
    }
}
