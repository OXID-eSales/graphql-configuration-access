<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleActivationController;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleActivationServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleActivationController
 */
class ModuleActivationControllerTest extends TestCase
{
    public function testActivateModule(): void
    {
        $moduleId = 'testModuleId';

        $moduleActivationServiceMock = $this->createMock(ModuleActivationServiceInterface::class);
        $moduleActivationServiceMock
            ->method('activateModule')
            ->with($moduleId)
            ->willReturn(true);

        $sut = $this->getSut(moduleActivationService: $moduleActivationServiceMock);

        $result = $sut->activateModule($moduleId);
        $this->assertTrue($result);
    }

    public function testDeactivateModule(): void
    {
        $moduleId = 'testModuleId';

        $moduleActivationServiceMock = $this->createMock(ModuleActivationServiceInterface::class);
        $moduleActivationServiceMock
            ->method('deactivateModule')
            ->with($moduleId)
            ->willReturn(true);

        $sut = $this->getSut(moduleActivationService: $moduleActivationServiceMock);

        $result = $sut->deactivateModule($moduleId);
        $this->assertTrue($result);
    }

    public function getSut(
        ModuleActivationServiceInterface $moduleActivationService = null
    ): ModuleActivationController {
        return new ModuleActivationController(
            moduleActivationService: $moduleActivationService
        );
    }
}
