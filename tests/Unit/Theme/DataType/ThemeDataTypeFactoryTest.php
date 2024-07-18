<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\DataType;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataTypeFactory
 */
class ThemeDataTypeFactoryTest extends TestCase
{
    public function testCreateThemeDataType(): void
    {
        $themeMock = $this->createMock(Theme::class);

        $expectedTitle = 'Test Theme';
        $expectedIdentifier = 'theme-id';
        $expectedVersion = '1.0.0';
        $expectedDescription = 'A test theme';
        $expectedActive = true;

        $themeMock->method('getInfo')
            ->will($this->returnValueMap([
                ['title', $expectedTitle],
                ['id', $expectedIdentifier],
                ['version', $expectedVersion],
                ['description', $expectedDescription],
                ['active', $expectedActive],
            ]));

        $factory = new ThemeDataTypeFactory();
        $themeDataType = $factory->createFromCoreTheme($themeMock);

        $this->assertInstanceOf(ThemeDataType::class, $themeDataType);
        $this->assertEquals($expectedTitle, $themeDataType->getTitle());
        $this->assertEquals($expectedIdentifier, $themeDataType->getIdentifier());
        $this->assertEquals($expectedVersion, $themeDataType->getVersion());
        $this->assertEquals($expectedDescription, $themeDataType->getDescription());
        $this->assertTrue($themeDataType->isActive());
    }
}
