<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\DataType;

use PHPUnit\Framework\TestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType
 */
class ThemeDataTypeTest extends TestCase
{
    public function testThemeDataType(): void
    {
        $name = 'test';
        $identifier = 'test';
        $version = '1.1';
        $description = 'This is description of theme';
        $active = true;

        $sut = new ThemeDataType($name, $identifier, $version, $description, $active);

        $this->assertSame($name, $sut->getTitle());
        $this->assertSame($identifier, $sut->getIdentifier());
        $this->assertSame($version, $sut->getVersion());
        $this->assertSame($description, $sut->getDescription());
        $this->assertSame($active, $sut->isActive());
    }
}
