<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException
 */
final class ModuleActivationExceptionTest extends TestCase
{
    public function testActivationException(): void
    {
        $exception = new ModuleActivationException();

        $this->assertInstanceOf(ModuleActivationException::class, $exception);
        $this->assertSame('An error occurred while activating the module.', $exception->getMessage());
    }

    public function testDeactivationException(): void
    {
        $exception = new ModuleDeactivationException();

        $this->assertInstanceOf(ModuleDeactivationException::class, $exception);
        $this->assertSame('An error occurred while deactivating the module.', $exception->getMessage());
    }
}
