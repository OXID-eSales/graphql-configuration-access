<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType
 */
class ModuleDataTypeTest extends UnitTestCase
{
    public function testModuleDataType(): void
    {
        $title = uniqid();
        $id = uniqid();
        $version = uniqid();
        $description = uniqid();
        $thumbnail = uniqid();
        $author = uniqid();
        $url = uniqid();
        $email = uniqid();
        $active = true;

        $moduleDataType = new ModuleDataType(
            id: $id,
            version: $version,
            title: $title,
            description: $description,
            thumbnail: $thumbnail,
            author: $author,
            url: $url,
            email: $email,
            active: $active
        );

        $this->assertSame($id, $moduleDataType->getId());
        $this->assertSame($version, $moduleDataType->getVersion());
        $this->assertSame($title, $moduleDataType->getTitle());
        $this->assertSame($description, $moduleDataType->getDescription());
        $this->assertSame($thumbnail, $moduleDataType->getThumbnail());
        $this->assertSame($author, $moduleDataType->getAuthor());
        $this->assertSame($url, $moduleDataType->getUrl());
        $this->assertSame($email, $moduleDataType->getEmail());
        $this->assertSame($active, $moduleDataType->isActive());
    }
}
