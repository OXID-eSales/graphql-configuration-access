<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Basket;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
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

    public function testGetStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingString(name: "stringSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingString" on type "Query".', $errorMessage);
    }

    public function testGetStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingString(name: "stringSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testGetSelectSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingSelect(name: "selectSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingSelect" on type "Query".', $errorMessage);
    }

    public function testGetSelectSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingSelect(name: "selectSetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingSelect'];
        $I->assertSame('selectSetting', $setting['name']);
        $I->assertSame('selectString', $setting['value']);
    }

    public function testGetCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingCollection(name: "arraySetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingCollection" on type "Query".', $errorMessage);
    }

    public function testGetCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingCollection(name: "arraySetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('["10","20","50","100"]', $setting['value']);
    }

    public function testGetAssocCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingAssocCollection(name: "aarraySetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingAssocCollection" on type "Query".', $errorMessage);
    }

    public function testGetAssocCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingAssocCollection(name: "aarraySetting") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['shopSettingAssocCollection'];
        $I->assertSame('aarraySetting', $setting['name']);
        $I->assertSame('{"first":"10","second":"20","third":"50"}', $setting['value']);
    }

    public function testGetShopSettingsListNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingsList {
                    name
                    type
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "shopSettingsList" on type "Query".', $errorMessage);
    }

    public function testGetShopSettingsListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                shopSettingsList {
                    name
                    type
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $settingsList = $result['data']['shopSettingsList'];
        $I->assertCount(7, $settingsList);
        $I->assertContains(['name'=>'intSetting', 'type' => FieldType::NUMBER], $settingsList);
        $I->assertContains(['name'=>'floatSetting', 'type' => FieldType::NUMBER], $settingsList);
        $I->assertContains(['name'=>'boolSetting', 'type' =>FieldType::BOOLEAN], $settingsList);
        $I->assertContains(['name'=>'stringSetting', 'type' => FieldType::STRING], $settingsList);
        $I->assertContains(['name'=>'selectSetting', 'type' => FieldType::SELECT], $settingsList);
        $I->assertContains(['name'=>'arraySetting', 'type' => FieldType::ARRAY], $settingsList);
        $I->assertContains(['name'=>'aarraySetting', 'type' => FieldType::ASSOCIATIVE_ARRAY], $settingsList);
    }
}
