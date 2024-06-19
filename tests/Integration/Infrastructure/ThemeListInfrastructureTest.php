<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructure;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListInfrastructureInterface;
use OxidEsales\Eshop\Core\Theme;

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
            $this->assertInstanceOf(ThemeDataType::class, $theme);
        }
    }

    public function testGetThemesThrowsException(): void
    {
        $coreThemeStub = $this->createMock(Theme::class);
        $coreThemeStub->method('getList')
            ->willReturn([]);
        $coreThemeFactoryMock = $this->getCoreThemeFactoryMock($coreThemeStub);

        $sut = $this->getSut(coreThemeFactory: $coreThemeFactoryMock);

        $this->expectException(ThemesNotFound::class);
        $sut->getThemes();
    }

    public function getSut(
        ?CoreThemeFactoryInterface $coreThemeFactory = null,
        ?ThemeDataTypeFactoryInterface $themeDataTypeFactory = null
    ): ThemeListInfrastructure {
        return new ThemeListInfrastructure(
            $coreThemeFactory ?? $this->get(CoreThemeFactoryInterface::class),
            $themeDataTypeFactory ?? $this->get(ThemeDataTypeFactoryInterface::class)
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
