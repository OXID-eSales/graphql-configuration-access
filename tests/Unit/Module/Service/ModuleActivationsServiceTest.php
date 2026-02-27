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
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationBlockedException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationBlockedException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleActivationService;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleBlocklistServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[AllowMockObjectsWithoutExpectations]
#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleActivationService::class)]
class ModuleActivationsServiceTest extends UnitTestCase
{
    #[DataProvider('activationDataProvider')]
    public function testModuleActivationAndDeactivationSuccess(
        string $method,
    ): void {
        $shopId = 1;
        $moduleId = uniqid();
        $moduleActivationBridgeMock = $this->createMock(ModuleActivationBridgeInterface::class);
        $moduleActivationBridgeMock
            ->method($method)
            ->with($moduleId, $shopId);

        $moduleBlocklistServiceMock = $this->createMock(ModuleBlocklistServiceInterface::class);
        $moduleBlocklistServiceMock
            ->method('isModuleBlocked')
            ->with($moduleId)
            ->willReturn(false);

        $sut = $this->getSut(
            context: $this->getContextMock($shopId),
            moduleActivationBridge: $moduleActivationBridgeMock
        );

        $result = ($method == 'activate') ? $sut->activateModule($moduleId) : $sut->deactivateModule($moduleId);

        $this->assertTrue($result);
    }

    #[DataProvider('exceptionDataProvider')]
    public function testModuleActivationAndDeactivationThrowsExceptions(
        string $method,
        mixed $exceptionClass
    ): void {
        $moduleId = uniqid();
        $moduleActivationBridgeMock = $this->createMock(ModuleActivationBridgeInterface::class);
        $moduleActivationBridgeMock
            ->method($method)
            ->with($moduleId, 1)
            ->willThrowException(new \Exception());

        $this->expectException($exceptionClass);

        $sut = $this->getSut(
            $this->getContextMock(),
            moduleActivationBridge: $moduleActivationBridgeMock
        );

        ($method === 'activate') ? $sut->activateModule($moduleId) : $sut->deactivateModule($moduleId);
    }

    #[DataProvider('moduleBlockedExceptionDataProvider')]
    public function testModuleActivationAndDeactivationBlockedException(
        string $method,
        mixed $exceptionClass
    ) {
        $moduleId = uniqid();
        $moduleBlockListServiceMock = $this->createMock(ModuleBlocklistServiceInterface::class);
        $moduleBlockListServiceMock
            ->method('isModuleBlocked')
            ->with($moduleId)
            ->willReturn(true);

        $sut = $this->getSut(
            moduleBlocklistService: $moduleBlockListServiceMock
        );

        $this->expectException($exceptionClass);
        ($method === 'activate') ? $sut->activateModule($moduleId) : $sut->deactivateModule($moduleId);
    }

    public static function moduleBlockedExceptionDataProvider(): \Generator
    {
        yield 'test activate module blocked exception' => [
            'method' => 'activate',
            'exceptionClass' => ModuleActivationBlockedException::class

        ];

        yield 'test deactivate module blocked exception' => [
            'method' => 'deactivate',
            'exceptionClass' => ModuleDeactivationBlockedException::class

        ];
    }

    public static function activationDataProvider(): \Generator
    {
        yield 'test activate module' => [
            'method' => 'activate',
        ];

        yield 'test deactivate module' => [
            'method' => 'deactivate',
        ];
    }

    public static function exceptionDataProvider(): \Generator
    {
        yield 'test activate module throws exception' => [
            'method' => 'activate',
            'exceptionClass' => ModuleActivationException::class

        ];

        yield 'test deactivate module throws exception' => [
            'method' => 'deactivate',
            'exceptionClass' => ModuleDeactivationException::class

        ];
    }

    public function getSut(
        ?ContextInterface $context = null,
        ?ModuleActivationBridgeInterface $moduleActivationBridge = null,
        ?ModuleBlocklistServiceInterface $moduleBlocklistService = null
    ): ModuleActivationService {
        return new ModuleActivationService(
            context: $context
                ??  $this->createStub(ContextInterface::class),
            moduleActivationBridge: $moduleActivationBridge
                ??  $this->createStub(ModuleActivationBridgeInterface::class),
            moduleBlocklistService: $moduleBlocklistService
                ??  $this->createStub(ModuleBlocklistServiceInterface::class)
        );
    }
}
