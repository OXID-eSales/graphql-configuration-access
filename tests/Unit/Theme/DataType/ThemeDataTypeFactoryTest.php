<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\DataType;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactory;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactory
 */
class ThemeDataTypeFactoryTest extends TestCase
{
    public function testCreateThemeDataType(): void
    {
        $themeMock = $this->createMock(Theme::class);

        $expectedTitle = uniqid();
        $expectedId = uniqid();
        $expectedVersion = uniqid();
        $expectedDescription = uniqid();
        $expectedActive = true;
        $expectedParentTheme = uniqid();
        $expectedParentVersions = [uniqid(), uniqid()];

        $themeMock->method('getInfo')
            ->willReturnMap([
                ['title', $expectedTitle],
                ['id', $expectedId],
                ['version', $expectedVersion],
                ['description', $expectedDescription],
                ['active', $expectedActive],
                ['parentTheme', $expectedParentTheme],
                ['parentVersions', $expectedParentVersions],
            ]);

        $factory = new ThemeDataTypeFactory();
        $themeDataType = $factory->createFromCoreTheme($themeMock);

        $this->assertInstanceOf(ThemeDataType::class, $themeDataType);
        $this->assertEquals($expectedTitle, $themeDataType->getTitle());
        $this->assertEquals($expectedId, $themeDataType->getId());
        $this->assertEquals($expectedVersion, $themeDataType->getVersion());
        $this->assertEquals($expectedDescription, $themeDataType->getDescription());
        $this->assertTrue($themeDataType->isActive());
    }
}
