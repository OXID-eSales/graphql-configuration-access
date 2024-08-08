<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType
 */
class ModuleDataTypeTest extends UnitTestCase
{
    public function testModuleDataType(): void
    {
        $thumbnail = uniqid();
        $author = uniqid();
        $url = uniqid();
        $email = uniqid();
        $lang = uniqid();

        $moduleDataType = new ModuleDataType(
            id: uniqid(),
            title: uniqid(),
            version: uniqid(),
            description: uniqid(),
            active: false,
            thumbnail: $thumbnail,
            author: $author,
            url: $url,
            email: $email,
            lang: $lang
        );

        $this->assertInstanceOf(ComponentDataTypeInterface::class, $moduleDataType);
        $this->assertSame($thumbnail, $moduleDataType->getThumbnail());
        $this->assertSame($author, $moduleDataType->getAuthor());
        $this->assertSame($url, $moduleDataType->getUrl());
        $this->assertSame($email, $moduleDataType->getEmail());
        $this->assertSame($lang, $moduleDataType->getLang());
    }
}
