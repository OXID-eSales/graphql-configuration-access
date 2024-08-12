<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridgeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleActivationService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleActivationService
 */
class ModuleActivationsServiceTest extends UnitTestCase
{
    /**
     * @dataProvider activationDataProvider
     */
    public function testModuleActivationAndDeactivation(
        string $method,
        string $moduleId,
        int $shopId
    ): void {
        $moduleActivationBridgeMock = $this->createMock(ModuleActivationBridgeInterface::class);
        $moduleActivationBridgeMock
            ->method($method)
            ->with($moduleId, $shopId);

        $sut = $this->getSut(
            context: $this->getContextMock(),
            moduleActivationBridge: $moduleActivationBridgeMock
        );

        $result = ($method == 'activate') ? $sut->activateModule($moduleId) : $sut->deactivateModule($moduleId);

        $this->assertTrue($result);
    }

    /**
     * @dataProvider exceptionDataProvider
     */
    public function testModuleActivationAndDeactivationExceptions(
        string $method,
        string $moduleId,
        mixed $exceptionClass
    ): void {

        $moduleActivationBridgeMock = $this->createMock(ModuleActivationBridgeInterface::class);
        $moduleActivationBridgeMock
            ->method($method)
            ->willThrowException(new \Exception());

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionClass::EXCEPTION_MESSAGE);

        $sut = $this->getSut(
            moduleActivationBridge: $moduleActivationBridgeMock
        );

        ($method === 'activate') ? $sut->activateModule($moduleId) : $sut->deactivateModule($moduleId);
    }

    public static function activationDataProvider(): \Generator
    {
        yield 'test activate module' => [
            'method' => 'activate',
            'moduleId' => uniqid(),
            'shopId' => 1
        ];

        yield 'test deactivate module' => [
            'method' => 'deactivate',
            'moduleId' => uniqid(),
            'shopId' => 1
        ];
    }

    public static function exceptionDataProvider(): \Generator
    {
        yield 'test activate module throws exception' => [
            'method' => 'activate',
            'moduleId' => uniqid(),
            'exceptionClass' => ModuleActivationException::class,

        ];

        yield 'test deactivate module throws exception' => [
            'method' => 'deactivate',
            'moduleId' => uniqid(),
            'exceptionClass' => ModuleDeactivationException::class,

        ];
    }

    public function getSut(
        ContextInterface $context = null,
        ModuleActivationBridgeInterface $moduleActivationBridge = null
    ): ModuleActivationService {
        return new ModuleActivationService(
            context: $context
                ??  $this->createStub(ContextInterface::class),
            moduleActivationBridge: $moduleActivationBridge
                ??  $this->createStub(ModuleActivationBridgeInterface::class)
        );
    }
}
