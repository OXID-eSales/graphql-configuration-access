<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\AbstractComponentDataType
 */
class ThemeDataTypeTest extends TestCase
{
    public function testThemeDataType(): void
    {
        $name = uniqid();
        $id = uniqid();
        $version = uniqid();
        $description = uniqid();
        $active = (bool)random_int(0, 1);
        $parentTheme = uniqid();
        $parentVersions = [uniqid(), uniqid()];

        $sut = new ThemeDataType($id, $name, $version, $description, $active, $parentTheme, $parentVersions);

        $this->assertInstanceOf(ComponentDataTypeInterface::class, $sut);
        $this->assertSame($name, $sut->getTitle());
        $this->assertSame($id, $sut->getId());
        $this->assertSame($version, $sut->getVersion());
        $this->assertSame($description, $sut->getDescription());
        $this->assertSame($active, $sut->isActive());
        $this->assertSame($parentTheme, $sut->getParentTheme());
        $this->assertSame($parentVersions, $sut->getParentVersions());
    }

    public function testThemeDataTypeWithNullableValues(): void
    {
        $name = uniqid();
        $id = uniqid();
        $version = uniqid();
        $description = uniqid();
        $active = (bool)random_int(0, 1);
        $parentTheme = null;
        $parentVersions = null;

        $sut = new ThemeDataType($id, $name, $version, $description, $active, $parentTheme, $parentVersions);

        $this->assertNull($sut->getParentTheme());
        $this->assertNull($sut->getParentVersions());
    }
}
