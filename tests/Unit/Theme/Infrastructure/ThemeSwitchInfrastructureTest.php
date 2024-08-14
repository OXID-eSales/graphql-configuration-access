<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSwitchInfrastructure;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSwitchInfrastructure
 */
class ThemeSwitchInfrastructureTest extends TestCase
{
    private const THEME_NOT_ACTIVATED = "An error occurred while activating the theme.";
    private const THEME_NOT_EXIST = "The specified theme doesn't exist.";
    public function testSwitchTheme(): void
    {
        $themeId = 'apex';
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->expects($this->once())->method('load')->with($themeId)->willReturn(true);
        $coreThemeMock->expects($this->once())->method('activate');

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(coreThemeMock: $coreThemeMock);
        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);

        $serviceResponse = $sut->switchTheme($themeId);
        $this->assertTrue($serviceResponse);
    }

    public function testThemeNotActivatedException(): void
    {
        $themeId = 'apex';
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->expects($this->once())->method('load')->with($themeId)->willReturn(true);
        $coreThemeMock->expects($this->once())->method('activate')
            ->will($this->throwException(
                new StandardException(self::THEME_NOT_ACTIVATED)
            ));

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(coreThemeMock: $coreThemeMock);
        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);

        $this->expectException(ThemeActivationException::class);
        $this->expectExceptionMessage(self::THEME_NOT_ACTIVATED);
        $sut->switchTheme($themeId);
    }

    public function testThemeNotFoundException(): void
    {
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('load')->willReturn(false);

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(coreThemeMock: $coreThemeMock);
        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);

        $this->expectException(ThemeActivationException::class);
        $this->expectExceptionMessage(self::THEME_NOT_EXIST);
        $sut->switchTheme('invalidThemeId');
    }

    private function getSut(
        CoreThemeFactoryInterface $coreThemeFactory,
    ): ThemeSwitchInfrastructure {
        return new ThemeSwitchInfrastructure(
            coreThemeFactory: $coreThemeFactory,
        );
    }

    private function getCoreThemeFactoryMock(Theme $coreThemeMock): CoreThemeFactoryInterface
    {
        $coreThemeFactoryMock = $this->createMock(CoreThemeFactoryInterface::class);
        $coreThemeFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($coreThemeMock);

        return $coreThemeFactoryMock;
    }
}
