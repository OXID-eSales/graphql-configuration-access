<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Basket;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class SettingCest extends BaseCest
{
    private const AGENT_USERNAME = 'JanvierJaimesVelasquez@cuvox.de';

    private const AGENT_PASSWORD = 'agent';

    public function _after(AcceptanceTester $I): void
    {
        $I->logout();
    }
    public function testGetSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "iTestConfiguration", moduleId: "oe_graphql_configuration_access") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        var_dump($result);
    }
}
