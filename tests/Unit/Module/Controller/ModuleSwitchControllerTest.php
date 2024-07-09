<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleSwitchController;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSwitchServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleSwitchController
 */
class ModuleSwitchControllerTest extends TestCase
{
    public function testActivateModule(): void
    {
        $moduleId = 'testModuleId';

        $moduleSwitchServiceMock = $this->createMock(ModuleSwitchServiceInterface::class);
        $moduleSwitchServiceMock
            ->method('activateModule')
            ->with($moduleId)
            ->willReturn(true);

        $sut = $this->getSut(moduleSwitchService: $moduleSwitchServiceMock);

        $result = $sut->activateModule($moduleId);
        $this->assertTrue($result);
    }

    public function testDeactivateModule(): void
    {
        $moduleId = 'testModuleId';

        $moduleSwitchServiceMock = $this->createMock(ModuleSwitchServiceInterface::class);
        $moduleSwitchServiceMock
            ->method('deactivateModule')
            ->with($moduleId)
            ->willReturn(true);

        $sut = $this->getSut(moduleSwitchService: $moduleSwitchServiceMock);

        $result = $sut->deactivateModule($moduleId);
        $this->assertTrue($result);
    }

    public function getSut(
        ModuleSwitchServiceInterface $moduleSwitchService = null
    ): ModuleSwitchController {
        return new ModuleSwitchController(
            moduleSwitchService: $moduleSwitchService
            ?? $this->createStub(ModuleSwitchServiceInterface::class)
        );
    }
}
