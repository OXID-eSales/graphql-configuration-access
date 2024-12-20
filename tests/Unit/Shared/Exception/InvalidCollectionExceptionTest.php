<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\InvalidCollectionException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\InvalidCollectionException
 */
class InvalidCollectionExceptionTest extends TestCase
{
    public function testExceptionMessage(): void
    {
        $value = uniqid();
        $sut = new InvalidCollectionException($value);
        $this->assertSame(sprintf('%s is not a valid collection string.', $value), $sut->getMessage());
    }
}
