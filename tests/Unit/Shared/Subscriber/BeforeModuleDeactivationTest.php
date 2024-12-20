<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Exception;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\BeforeModuleDeactivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Exception\ModuleSetupValidationException;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Subscriber\BeforeModuleDeactivation;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Subscriber\BeforeModuleDeactivation
 */
class BeforeModuleDeactivationTest extends TestCase
{
    public function testHandle()
    {
        $dependencies = [];
        $dependencies[] = uniqid();
        $dependencies[] = uniqid();

        $beforeModuleDeactivationEvent = $this->createConfiguredStub(BeforeModuleDeactivationEvent::class, [
            'getModuleId' => uniqid('module')
        ]);

        $sut = new BeforeModuleDeactivation($dependencies);
        $returnEvent = $sut->handle($beforeModuleDeactivationEvent);
        $this->assertSame($beforeModuleDeactivationEvent, $returnEvent);
    }

    public function testHandleThrowsModuleSetupValidationException()
    {
        $dependencies = [];
        $dependencies[] = uniqid();
        $dependencies[] = uniqid();

        $dependenciesKey = array_rand($dependencies);
        $dependency = $dependencies[$dependenciesKey];

        $beforeModuleDeactivationEvent = $this->createConfiguredStub(BeforeModuleDeactivationEvent::class, [
            'getModuleId' => $dependency
        ]);

        $this->expectException(ModuleSetupValidationException::class);
        $this->expectExceptionMessage((new ModuleSetupValidationException('Module with id "' . $dependency .
            '" cannot be deactivated while GraphQL Configuration Access module is active.'))->getMessage());

        $sut = new BeforeModuleDeactivation($dependencies);
        $sut->handle($beforeModuleDeactivationEvent);
    }
}
