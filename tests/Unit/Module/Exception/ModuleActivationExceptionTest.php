<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException
 */
final class ModuleActivationExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new ModuleActivationException();

        $this->assertInstanceOf(ModuleActivationException::class, $exception);
        $this->assertSame(ModuleActivationException::EXCEPTION_MESSAGE, $exception->getMessage());
    }
}
