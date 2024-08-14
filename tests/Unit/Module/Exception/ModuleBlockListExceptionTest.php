<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleBlockListException
 */
final class ModuleBlockListExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new ModuleBlockListException();

        $this->assertInstanceOf(ModuleBlockListException::class, $exception);
        $this->assertSame('Failed to load module blocklist from YAML file.', $exception->getMessage());
    }
}
