<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeSwitchController;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSwitchServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeSwitchController
 */
class ThemeSwitchControllerTest extends TestCase
{
    /** @dataProvider switchThemeProvider */
    public function testSwitchTheme(
        string $identifier,
        bool $expectedResult
    ): void {
        $themeSwitchServiceMock = $this->createMock(ThemeSwitchServiceInterface::class);
        $themeSwitchServiceMock
            ->method('switchTheme')
            ->with($identifier)
            ->willReturn($expectedResult);

        $themeSwitchController = new ThemeSwitchController($themeSwitchServiceMock);
        $response = $themeSwitchController->switchTheme($identifier);

        $this->assertSame($expectedResult, $response);
    }

    public static function switchThemeProvider(): \Generator
    {
        yield 'test switch theme successful case' => [
            'identifier' => 'validThemeId',
            'expectedResult' => true
        ];

        yield 'test switch theme failure case' => [
            'identifier' => 'invalidThemeId',
            'expectedResult' => false
        ];
    }
}
