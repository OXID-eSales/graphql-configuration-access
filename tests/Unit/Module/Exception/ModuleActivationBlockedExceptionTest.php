<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationBlockedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationBlockedException::class)]
final class ModuleActivationBlockedExceptionTest extends TestCase
{
    public function testException(): void
    {
        $moduleId = uniqid();
        $exception = new ModuleActivationBlockedException($moduleId);

        $this->assertInstanceOf(ModuleActivationBlockedException::class, $exception);
        $this->assertSame(
            sprintf('Module "%s" is in the blocklist and cannot be activated.', $moduleId),
            $exception->getMessage()
        );
    }
}
