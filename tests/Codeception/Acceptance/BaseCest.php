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
    public const TEST_MODULE_ID = 'awesomeModule';
    public const TEST_THEME_ID = 'awesomeTheme';

    private const AGENT_USERNAME = 'JanvierJaimesVelasquez@cuvox.de';

    private const AGENT_PASSWORD = 'agent';

    private const ADMIN_USERNAME = 'noreply@oxid-esales.com';

    private const ADMIN_PASSWORD = 'admin';

    public function _after(AcceptanceTester $I): void
    {
        $I->logout();
    }

    protected function getTestThemeName(): string
    {
        return self::TEST_THEME_ID;
    }

    protected function getAgentUsername(): string
    {
        return self::AGENT_USERNAME;
    }

    protected function getAgentPassword(): string
    {
        return self::AGENT_PASSWORD;
    }

    protected function getAdminUsername(): string
    {
        return self::ADMIN_USERNAME;
    }

    protected function getAdminPassword(): string
    {
        return self::ADMIN_PASSWORD;
    }
}
