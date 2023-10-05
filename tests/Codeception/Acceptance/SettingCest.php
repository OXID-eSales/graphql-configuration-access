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

    private const ADMIN_USERNAME = 'noreply@oxid-esales.com';

    private const ADMIN_PASSWORD = 'admin';

    public function testGetSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "intSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingInteger" on type "Query".', $errorMessage);
    }

    public function testGetSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "intSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);
    }
}
