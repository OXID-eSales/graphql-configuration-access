<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactory;
use PHPUnit\Framework\TestCase;
use OxidEsales\Eshop\Core\Theme;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\CoreThemeFactory
 */
class CoreThemeFactoryTest extends TestCase
{
    public function testCreateProducesCorrectTypeOfObjects(): void
    {
        $sut = $this->getSut();
        $this->assertInstanceOf(Theme::class, $sut->create());
    }

    public function testCreateProducesDifferentObjectsOnEveryCall(): void
    {
        $model1 = $this->getSut()->create();
        $model2 = $this->getSut()->create();

        $this->assertNotSame($model1, $model2);
    }

    private function getSut(): CoreThemeFactory
    {
        $coreThemeFactoryMock = $this->getMockBuilder(CoreThemeFactory::class)
            ->onlyMethods(['createTheme'])
            ->getMock();

        $coreThemeFactoryMock->method('createTheme')
            ->willReturn(new Theme());

        return $coreThemeFactoryMock;
    }
}
