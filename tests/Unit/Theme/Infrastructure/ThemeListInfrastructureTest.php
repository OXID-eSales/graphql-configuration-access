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
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeNotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure
 */
class ThemeListInfrastructureTest extends TestCase
{
    public function notestGetThemesWithoutFilter(): void
    {
        $coreThemeMock = $this->createMock(Theme::class);

        $theme1 = $this->createThemeMock('Test Theme 1', 'theme id 1', 'v1.0', 'test description 1', true);
        $theme2 = $this->createThemeMock('Test Theme 2', 'theme id 2', 'v2.0', 'test description 2', false);

        $coreThemeMock->method('getList')
            ->willReturn([$theme1, $theme2]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeMock);

        $themeDataTypeFactoryMock = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $themeDataTypeFactoryMock->method('createFromCoreTheme')->willReturn(
            new ThemeDataType(
                'Test Theme 1',
                'theme1',
                '1.0',
                'Description 1',
                true
            )
        );

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock, themeDataTypeFactory: $themeDataTypeFactoryMock);
        $result = $sut->getThemes();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(ThemeDataType::class, $result[0]);
        $this->assertInstanceOf(ThemeDataType::class, $result[1]);

        $this->assertSame('Test Theme 1', $result[0]->getTitle());
        $this->assertSame('theme id 1', $result[0]->getIdentifier());
        $this->assertSame('v1.0', $result[0]->getVersion());
        $this->assertSame('test description 1', $result[0]->getDescription());
        $this->assertTrue($result[0]->isActive());

        $this->assertSame('Test Theme 2', $result[1]->getTitle());
        $this->assertSame('theme id 2', $result[1]->getIdentifier());
        $this->assertSame('v2.0', $result[1]->getVersion());
        $this->assertSame('test description 2', $result[1]->getDescription());
        $this->assertFalse($result[1]->isActive());
    }

    public function testGetThemesThrowsException(): void
    {
        $coreThemeStub = $this->createMock(Theme::class);
        $coreThemeStub->method('getList')
            ->willReturn([]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeStub);

        $themeDataTypeFactoryMock = $this->createMock(ThemeDataTypeFactoryInterface::class);
        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock, themeDataTypeFactory: $themeDataTypeFactoryMock);

        $this->expectException(ThemeNotFound::class);
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
            ->method('getClass')
            ->willReturn($returnValue);

        return $coreThemeFactoryMock;
    }
}
