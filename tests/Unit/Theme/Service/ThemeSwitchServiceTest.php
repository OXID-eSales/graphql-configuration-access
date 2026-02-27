<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSwitchInfrastructureInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSwitchService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSwitchService::class)]
class ThemeSwitchServiceTest extends TestCase
{
    #[DataProvider('switchThemeProvider')]
    public function testSwitchTheme(
        bool $expectedResult
    ): void {
        $themeId = uniqid();
        $themeSwitchInfrastructureMock = $this->createMock(ThemeSwitchInfrastructureInterface::class);
        $themeSwitchInfrastructureMock
            ->method('switchTheme')
            ->with($themeId)
            ->willReturn($expectedResult);

        $themeSwitchInfrastructure = new ThemeSwitchService($themeSwitchInfrastructureMock);
        $response = $themeSwitchInfrastructure->switchTheme($themeId);

        $this->assertSame($expectedResult, $response);
    }

    public static function switchThemeProvider(): \Generator
    {
        yield 'test switch theme successful case' => [
            'expectedResult' => true
        ];

        yield 'test switch theme failure case' => [
            'expectedResult' => false
        ];
    }
}
