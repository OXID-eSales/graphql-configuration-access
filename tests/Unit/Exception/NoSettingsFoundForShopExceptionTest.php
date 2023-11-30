<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForShopException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForShopException
 */
class NoSettingsFoundForShopExceptionTest extends TestCase
{
    public function testMessageThroughConstructor()
    {
        $sut = new NoSettingsFoundForShopException(5);
        $this->assertMatchesRegularExpression("/for shop: 5$/", $sut->getMessage());
    }
}
