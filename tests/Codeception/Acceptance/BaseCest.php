<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

abstract class BaseCest
{
    private const TEST_MODULE_ID = 'awesomeModule';
    private const TEST_THEME_ID = 'awesomeTheme';

    public function _after(AcceptanceTester $I): void
    {
        $I->logout();
    }

    protected function getTestModuleName(): string
    {
        return self::TEST_MODULE_ID;
    }

    protected function getTestThemeName(): string
    {
        return self::TEST_THEME_ID;
    }
}
