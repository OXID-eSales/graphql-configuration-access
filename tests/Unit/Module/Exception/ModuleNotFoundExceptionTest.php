<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleNotFoundException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(ModuleNotFoundException::class)]
final class ModuleNotFoundExceptionTest extends TestCase
{
    #[Test]
    public function getMessageContainsModuleId(): void
    {
        $moduleId = uniqid();

        $sut = new ModuleNotFoundException($moduleId);

        $this->assertInstanceOf(NotFound::class, $sut);
        $this->assertSame(sprintf('Module was not found: %s', $moduleId), $sut->getMessage());
    }

    #[Test]
    public function exceptionIsClientAware(): void
    {
        $sut = new ModuleNotFoundException(uniqid());

        $this->assertTrue($sut->isClientSafe());
    }
}
