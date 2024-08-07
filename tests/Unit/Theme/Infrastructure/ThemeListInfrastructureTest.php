<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure
 */
class ThemeListInfrastructureTest extends TestCase
{
    public function testGetThemes(): void
    {
        $theme1 = $this->createStub(Theme::class);
        $theme2 = $this->createStub(Theme::class);

        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('getList')->willReturn([$theme1, $theme2]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(returnValue: $coreThemeMock);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);
        $actualThemesArray = $sut->getThemes();
        $this->assertSame([$theme1, $theme2], $actualThemesArray);
    }

    public function testGetThemesThrowsException(): void
    {
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('getList')->willReturn([]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(returnValue: $coreThemeMock);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);

        $this->expectException(ThemesNotFound::class);
        $sut->getThemes();
    }

    private function getSut(
        CoreThemeFactoryInterface $coreThemeFactory
    ): ThemeListInfrastructure {
        return new ThemeListInfrastructure(
            coreThemeFactory: $coreThemeFactory
        );
    }

    private function getCoreThemeFactoryMock(Theme $returnValue): CoreThemeFactoryInterface
    {
        $coreThemeFactoryMock = $this->createMock(CoreThemeFactoryInterface::class);
        $coreThemeFactoryMock->method('create')
            ->willReturn($returnValue);

        return $coreThemeFactoryMock;
    }
}
