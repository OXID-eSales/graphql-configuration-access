<?php

/**
* Copyright © OXID eSales AG. All rights reserved.
* See LICENSE file for license details.
*/

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemesNotFound;
use PHPUnit\Framework\TestCase;

/**
* @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeActivationException
*/
class ThemeActivationExceptionTest extends TestCase
{
    private const THEME_NOT_ACTIVATED_MESSAGE = "An error occurred while activating the theme.";

    public function testThemeActivationExceptionDefaultMessage()
    {
        $exception = new ThemeActivationException();

        $this->assertInstanceOf(ThemeActivationException::class, $exception);
        $this->assertSame(self::THEME_NOT_ACTIVATED_MESSAGE, $exception->getMessage());
    }

    public function testThemeActivationExceptionWithMessage()
    {
        $message = uniqid();
        $exception = new ThemeActivationException($message);

        $this->assertInstanceOf(ThemeActivationException::class, $exception);
        $this->assertSame($message, $exception->getMessage());
    }
}
