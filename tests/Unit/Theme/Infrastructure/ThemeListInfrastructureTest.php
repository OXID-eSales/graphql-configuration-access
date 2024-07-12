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
        $expectedThemes = [$theme1, $theme2];

        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('getList')
            ->willReturn($expectedThemes);

        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeMock);
        $themeDataTypeFactoryMock = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $themeDataTypeFactoryMock->method('createFromCoreTheme')->will($this->returnCallback(function (Theme $theme) {
            return new ThemeDataType(
                $theme->getInfo('title'),
                $theme->getInfo('id'),
                $theme->getInfo('version'),
                $theme->getInfo('description'),
                $theme->getInfo('active')
            );
        }));

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock, themeDataTypeFactory: $themeDataTypeFactoryMock);
        $actualThemesArray = $sut->getThemes();
        $actualTheme1 = $actualThemesArray[0];
        $actualTheme2 = $actualThemesArray[1];

        $this->assertCount(2, $actualThemesArray);
        $this->assertInstanceOf(ThemeDataType::class, $actualTheme1);
        $this->assertSame($theme1->getInfo('title'), $actualTheme1->getTitle());
        $this->assertSame($theme2->getInfo('title'), $actualTheme2->getTitle());
        $this->assertSame($theme1->getInfo('active'), $actualTheme1->isActive());
        $this->assertSame($theme2->getInfo('active'), $actualTheme2->isActive());
    }

    public function testGetThemesThrowsException(): void
    {
        $coreThemeStub = $this->createMock(Theme::class);
        $coreThemeStub->method('getList')
            ->willReturn([]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeStub);

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
    ) {
        $themeMock = $this->createMock(Theme::class);
        $themeMock->method('getInfo')
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

    private function getCoreThemeFactoryMock(mixed $returnValue): CoreThemeFactoryInterface
    {
        $coreThemeFactoryMock = $this->createMock(CoreThemeFactoryInterface::class);
        $coreThemeFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($returnValue);

        return $coreThemeFactoryMock;
    }
}
