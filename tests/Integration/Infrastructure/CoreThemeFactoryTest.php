<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactory;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactory
 */
class CoreThemeFactoryTest extends IntegrationTestCase
{
    public function testCreate()
    {
        $coreThemeFactory = new CoreThemeFactory();
        $theme = $coreThemeFactory->create();
        $this->assertEquals(new Theme(), $theme);

        $anotherTheme = $coreThemeFactory->create();
        $this->assertNotEquals($theme, $anotherTheme);
    }
}
