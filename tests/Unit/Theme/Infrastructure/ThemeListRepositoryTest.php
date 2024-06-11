<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\OxNewFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeNotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeListRepository
 */
class ThemeListRepositoryTest extends TestCase
{
    public function testGetThemesWithoutFilter(): void
    {
        $themeServiceStub = $this->createMock(Theme::class);
        $theme1 = $this->createThemeMock('Test Theme 1', 'theme id 1', 'v1.0', 'test description 1', true);
        $theme2 = $this->createThemeMock('Test Theme 2', 'theme id 2', 'v2.0', 'test description 2', false);

        $themeServiceStub->method('getList')
            ->willReturn([$theme1, $theme2]);
        $oxNewFactoryMock = $this->getOxNewFactoryByClass(Theme::class, $themeServiceStub);

        $sut = $this->getSut(oxNewFactory: $oxNewFactoryMock);
        $result = $sut->getThemes(null, null);

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
        $themeServiceStub = $this->createMock(Theme::class);
        $themeServiceStub->method('getList')
            ->willReturn([]);
        $oxNewFactoryMock = $this->getOxNewFactoryByClass(Theme::class, $themeServiceStub);

        $sut = $this->getSut(oxNewFactory: $oxNewFactoryMock);
        $this->expectException(ThemeNotFound::class);
        $sut->getThemes(null, null);
    }

    private function createThemeMock(
        string $title,
        string $id,
        string $version,
        string $description,
        bool $active
    ): MockObject {
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
        OxNewFactoryInterface $oxNewFactory = null
    ): ThemeListRepository {
        return new ThemeListRepository(
            oxNewFactory: $oxNewFactory ?? $this->createStub(OxNewFactoryInterface::class)
        );
    }

    private function getOxNewFactoryByClass(string $class, mixed $returnValue): OxNewFactoryInterface
    {
        $oxNewFactoryMock = $this->createMock(OxNewFactoryInterface::class);
        $oxNewFactoryMock->expects($this->once())
            ->method('getModel')
            ->with($class)
            ->willReturn($returnValue);

        return $oxNewFactoryMock;
    }
}
