<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\CollectionEncodingException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\CollectionEncodingException::class)]
class CollectionEncodingExceptionTest extends TestCase
{
    public function testExceptionMessage()
    {
        $sut = new CollectionEncodingException();
        $this->assertSame('Error encountered while encoding collection data', $sut->getMessage());
    }
}
