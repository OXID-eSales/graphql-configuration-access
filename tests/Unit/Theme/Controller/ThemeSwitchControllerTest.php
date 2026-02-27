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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeSwitchController::class)]
class ThemeSwitchControllerTest extends TestCase
{
    #[DataProvider('switchThemeProvider')]
    public function testSwitchTheme(
        string $themeId,
        bool $expectedResult
    ): void {
        $themeSwitchServiceMock = $this->createMock(ThemeSwitchServiceInterface::class);
        $themeSwitchServiceMock
            ->method('switchTheme')
            ->with($themeId)
            ->willReturn($expectedResult);

        $themeSwitchController = new ThemeSwitchController($themeSwitchServiceMock);
        $response = $themeSwitchController->switchTheme($themeId);

        $this->assertSame($expectedResult, $response);
    }

    public static function switchThemeProvider(): \Generator
    {
        yield 'test switch theme successful case' => [
            'themeId' => 'validThemeId',
            'expectedResult' => true
        ];

        yield 'test switch theme failure case' => [
            'themeId' => 'invalidThemeId',
            'expectedResult' => false
        ];
    }
}
