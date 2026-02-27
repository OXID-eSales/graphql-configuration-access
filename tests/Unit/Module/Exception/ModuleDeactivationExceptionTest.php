<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException::class)]
final class ModuleDeactivationExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new ModuleDeactivationException();

        $this->assertInstanceOf(ModuleDeactivationException::class, $exception);
        $this->assertSame('An error occurred while deactivating the module.', $exception->getMessage());
    }
}
