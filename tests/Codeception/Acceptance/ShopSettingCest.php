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
 * @group shop_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ShopSettingCest extends BaseCest
{
    public function testGetIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingInteger(name: "intSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingInteger" on type "Query".', $errorMessage);
    }

    public function testGetIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingInteger(name: "intSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(123, $setting['value']);
    }

    public function testGetFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingFloat(name: "floatSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingFloat" on type "Query".', $errorMessage);
    }

    public function testGetFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingFloat(name: "floatSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.23, $setting['value']);
    }

    public function testGetBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingBoolean(name: "boolSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingBoolean" on type "Query".', $errorMessage);
    }

    public function testGetBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingBoolean(name: "boolSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }
}
