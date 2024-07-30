<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure
 */
class ThemeListInfrastructureTest extends TestCase
{
    public function testGetThemes(): void
    {
        $theme1 = [
            'title' => uniqid(),
            'id' => uniqid(),
            'version' => uniqid(),
            'description' => uniqid(),
            'active' => true
        ];

        $theme2 = [
            'title' => uniqid(),
            'id' => uniqid(),
            'version' => uniqid(),
            'description' => uniqid(),
            'active' => false
        ];

        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->expects($this->once())->method('getList')
            ->willReturn([$theme1, $theme2]);

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(returnValue: $coreThemeMock);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);
        $actualThemesArray = $sut->getThemes();
        $this->assertEquals([$theme1, $theme2], $actualThemesArray);
    }

    public function testGetThemesThrowsException(): void
    {
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->expects($this->once())->method('getList')
            ->willReturn([]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(returnValue: $coreThemeMock);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);

        $this->expectException(ThemesNotFound::class);
        $sut->getThemes();
    }

    private function getSut(
        CoreThemeFactoryInterface $coreThemeFactory = null
    ): ThemeListInfrastructure {
        return new ThemeListInfrastructure(
            coreThemeFactory: $coreThemeFactory ?? $this->createStub(CoreThemeFactoryInterface::class)
        );
    }

    private function getCoreThemeFactoryMock(Theme $returnValue): CoreThemeFactoryInterface
    {
        $coreThemeFactoryMock = $this->createMock(CoreThemeFactoryInterface::class);
        $coreThemeFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($returnValue);

        return $coreThemeFactoryMock;
    }
}
