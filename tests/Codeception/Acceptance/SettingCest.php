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

    public function testGetIntegerSettingNotAuthorized(AcceptanceTester $I): void
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

    public function testGetIntegerSettingAuthorized(AcceptanceTester $I): void
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

        $setting = $result['data']['moduleSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(123, $setting['value']);
    }

    public function testGetFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingFloat(name: "floatSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingFloat" on type "Query".', $errorMessage);
    }

    public function testGetFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingFloat(name: "floatSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.23, $setting['value']);
    }

    public function testGetBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingBoolean(name: "boolSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingBoolean" on type "Query".', $errorMessage);
    }

    public function testGetBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingBoolean(name: "boolSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    public function testGetStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingString(name: "stringSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingString" on type "Query".', $errorMessage);
    }

    public function testGetStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingString(name: "stringSetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testGetCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingCollection(name: "arraySetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingCollection" on type "Query".', $errorMessage);
    }

    public function testGetCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingCollection(name: "arraySetting", moduleId: "'.$this->getTestModuleName().'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('["nice","values"]', $setting['value']);
    }
}
