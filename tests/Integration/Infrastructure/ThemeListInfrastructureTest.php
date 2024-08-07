<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure
 */
class ThemeListInfrastructureTest extends IntegrationTestCase
{
    public function testGetThemesValidData(): void
    {
        $sut = $this->getSut();

        $themesArray = $sut->getThemes();
        $this->assertNotEmpty($themesArray);
        $this->assertIsArray($themesArray);

        foreach ($themesArray as $theme) {
            $this->assertInstanceOf(Theme::class, $theme);
        }
    }

    public function getSut(): ThemeListInfrastructure
    {
        return new ThemeListInfrastructure(
            $this->get(CoreThemeFactoryInterface::class),
        );
    }
}
