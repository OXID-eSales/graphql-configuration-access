<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\NoSettingsFoundForThemeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\NoSettingsFoundForThemeException
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\NoSettingsFoundException
 */
class NoSettingsFoundForThemeExceptionTest extends TestCase
{
    public function testMessageThroughConstructor()
    {
        $sut = new NoSettingsFoundForThemeException('someTheme');
        $this->assertMatchesRegularExpression("/for theme: someTheme$/", $sut->getMessage());
    }
}
