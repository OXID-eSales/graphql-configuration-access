<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactory;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSwitchInfrastructure;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSwitchInfrastructure
 */
class ThemeSwitchInfrastructureTest extends IntegrationTestCase
{
    public function testSwitchTheme()
    {
        $sut = $this->getSut();
        $result = $sut->switchTheme($this->getThemeId());

        $this->assertTrue($result);
    }
	
    private function getSut(
        ?CoreThemeFactoryInterface $coreThemeFactory = null
    ): ThemeSwitchInfrastructure {
        return new ThemeSwitchInfrastructure(
            $coreThemeFactory ?? $this->get(CoreThemeFactoryInterface::class)
        );
    }

    private function getThemeId(): string
    {
        return getenv('THEME_ID') ?: 'apex';
    }
}
