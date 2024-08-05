<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModulesNotFoundException
 */
class ModulesNotFoundExceptionTest extends TestCase
{
    public function testModulesNotFoundException()
    {
        $exception = new ModulesNotFoundException();

        $this->assertInstanceOf(ModulesNotFoundException::class, $exception);
        $this->assertSame('Modules were not found.', $exception->getMessage());
    }
}
