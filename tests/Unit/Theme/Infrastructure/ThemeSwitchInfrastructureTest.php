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
    public function testSwitchTheme(): void
    {
        $identifier = 'apex';
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('load')->with($identifier)->willReturn(true);
        $coreThemeMock->method('activate');

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(coreThemeMock: $coreThemeMock);
        $sut = $this->getSut($coreThemeFactoryMock);

        $serviceResponse = $sut->switchTheme($identifier);
        $this->assertTrue($serviceResponse);
    }

    public function testThemeNotActivatedException(): void
    {
        $identifier = 'apex';
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('load')->with($identifier)->willReturn(true);
        $coreThemeMock->method('activate')->will(
            $this->throwException(
                new StandardException(ThemeActivationException::THEME_NOT_ACTIVATED)
            )
        );

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(coreThemeMock: $coreThemeMock);
        $sut = $this->getSut($coreThemeFactoryMock);

        $this->expectException(ThemeActivationException::class);
        $this->expectExceptionMessage(ThemeActivationException::THEME_NOT_ACTIVATED);
        $sut->switchTheme($identifier);
    }

    public function testThemeNotFoundException(): void
    {
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('load')->willReturn(false);

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(coreThemeMock: $coreThemeMock);
        $sut = $this->getSut($coreThemeFactoryMock);

        $this->expectException(ThemeActivationException::class);
        $this->expectExceptionMessage(ThemeActivationException::THEME_NOT_EXIST);
        $sut->switchTheme('invalidThemeId');
    }

    private function getSut(
        CoreThemeFactoryInterface $coreThemeFactory = null,
    ): ThemeSwitchInfrastructure {
        return new ThemeSwitchInfrastructure(
            coreThemeFactory: $coreThemeFactory ?? $this->createStub(ThemeSwitchInfrastructure::class),
        );
    }

    private function getCoreThemeFactoryMock($coreThemeMock): CoreThemeFactoryInterface
    {
        $coreThemeFactoryMock = $this->createMock(CoreThemeFactoryInterface::class);
        $coreThemeFactoryMock->expects($this->once())
            ->method('getClass')
            ->willReturn($coreThemeMock);

        return $coreThemeFactoryMock;
    }
}
