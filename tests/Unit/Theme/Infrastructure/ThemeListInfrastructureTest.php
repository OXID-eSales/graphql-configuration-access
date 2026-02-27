<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[AllowMockObjectsWithoutExpectations]
#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure::class)]
class ThemeListInfrastructureTest extends TestCase
{
    public function testGetThemes(): void
    {
        $theme1 = $this->createStub(Theme::class);
        $theme2 = $this->createStub(Theme::class);
        $themeDataType1 = $this->createStub(ThemeDataType::class);
        $themeDataType2 = $this->createStub(ThemeDataType::class);

        $coreThemeMock = $this->createMock(Theme::class);
        $coreThemeMock->method('getList')->willReturn([$theme1, $theme2]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock(returnValue: $coreThemeMock);

        $themeDataTypeFactory = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $themeDataTypeFactory->method('createFromCoreTheme')->willReturnMap([
            [$theme1, $themeDataType1],
            [$theme2, $themeDataType2]
        ]);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock, themeDataTypeFactory: $themeDataTypeFactory);
        $actualThemesArray = $sut->getThemes();
        $this->assertSame([$themeDataType1, $themeDataType2], $actualThemesArray);
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
        ?CoreThemeFactoryInterface $coreThemeFactory = null,
        ?ThemeDataTypeFactoryInterface $themeDataTypeFactory = null
    ): ThemeListInfrastructure {
        return new ThemeListInfrastructure(
            coreThemeFactory: $coreThemeFactory ?? $this->createStub(CoreThemeFactoryInterface::class),
            themeDataTypeFactory: $themeDataTypeFactory ?? $this->createStub(ThemeDataTypeFactoryInterface::class)
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
