<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\AbstractComponentDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType::class)]
class AbstractComponentDataTypeTest extends UnitTestCase
{
    public function testAbstractComponentDataType(): void
    {
        $id = uniqid();
        $title = uniqid();
        $version = uniqid();
        $description = uniqid();
        $isActive = (bool)random_int(0, 1);

        $component = new class ($id, $title, $version, $description, $isActive) extends AbstractComponentDataType {
        };

        $this->assertSame($id, $component->getId());
        $this->assertSame($title, $component->getTitle());
        $this->assertSame($version, $component->getVersion());
        $this->assertSame($description, $component->getDescription());
        $this->assertSame($isActive, $component->isActive());
    }
}
