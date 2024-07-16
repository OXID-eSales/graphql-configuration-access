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
        $theme1 = $this->createThemeMock(uniqid(), uniqid(), uniqid(), uniqid(), true);
        $theme2 = $this->createThemeMock(uniqid(), uniqid(), uniqid(), uniqid(), false);

        $convertThemeCallback = function (Theme $theme) {
            return new ThemeDataType(
                $theme->getInfo('title'),
                $theme->getInfo('id'),
                $theme->getInfo('version'),
                $theme->getInfo('description'),
                $theme->getInfo('active')
            );
        };
        $theme1DataType = $convertThemeCallback($theme1);
        $theme2DataType = $convertThemeCallback($theme2);

        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->expects($this->once())->method('getList')
            ->willReturn([$theme1, $theme2]);

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeMock);
        $themeDataTypeFactoryMock = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $themeDataTypeFactoryMock->expects($this->exactly(2))->method('createFromCoreTheme')
            ->with($this->logicalOr($theme1, $theme2))
            ->willReturnCallback($convertThemeCallback);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock, themeDataTypeFactory: $themeDataTypeFactoryMock);
        $actualThemesArray = $sut->getThemes();
        $this->assertEquals([$theme1DataType, $theme2DataType], $actualThemesArray);
    }

    public function testGetThemesThrowsException(): void
    {
        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->expects($this->once())->method('getList')
            ->willReturn([]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeMock);

        $themeDataTypeFactoryMock = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock, themeDataTypeFactory: $themeDataTypeFactoryMock);

        $this->expectException(ThemesNotFound::class);
        $sut->getThemes();
    }

    private function createThemeMock(
        string $title,
        string $id,
        string $version,
        string $description,
        bool $active
    ): Theme|MockObject {
        $themeMock = $this->createMock(Theme::class);
        $themeMock->expects($this->exactly(10))
            ->method('getInfo')
            ->willReturnMap([
                ['title', $title],
                ['id', $id],
                ['version', $version],
                ['description', $description],
                ['active', $active]
            ]);

        return $themeMock;
    }

    private function getSut(
        CoreThemeFactoryInterface $coreThemeFactory = null,
        ThemeDataTypeFactoryInterface $themeDataTypeFactory = null
    ): ThemeListInfrastructure {
        return new ThemeListInfrastructure(
            coreThemeFactory: $coreThemeFactory ?? $this->createStub(CoreThemeFactoryInterface::class),
            themeDataTypeFactory: $themeDataTypeFactory ?? $this->createStub(ThemeDataTypeFactoryInterface::class)
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
