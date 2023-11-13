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
 * @group theme_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ThemeSettingCest extends BaseCest
{
    public function testGetIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingInteger(name: "intSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingInteger" on type "Query".', $errorMessage);
    }

    public function testGetIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingInteger(name: "intSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(123, $setting['value']);
    }

    public function testGetFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingFloat(name: "floatSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingFloat" on type "Query".', $errorMessage);
    }

    public function testGetFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingFloat(name: "floatSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.23, $setting['value']);
    }

    public function testGetBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingBoolean(name: "boolSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingBoolean" on type "Query".', $errorMessage);
    }

    public function testGetBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingBoolean(name: "boolSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    public function testGetStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingString(name: "stringSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingString" on type "Query".', $errorMessage);
    }

    public function testGetStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingString(name: "stringSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testGetSelectSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingSelect(name: "selectSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingSelect" on type "Query".', $errorMessage);
    }

    public function testGetSelectSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingSelect(name: "selectSetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingSelect'];
        $I->assertSame('selectSetting', $setting['name']);
        $I->assertSame('selectString', $setting['value']);
    }

    public function testGetCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingCollection(name: "arraySetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingCollection" on type "Query".', $errorMessage);
    }

    public function testGetCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingCollection(name: "arraySetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('["10","20","50","100"]', $setting['value']);
    }

    public function testGetAssocCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingAssocCollection(name: "aarraySetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingAssocCollection" on type "Query".', $errorMessage);
    }

    public function testGetAssocCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                themeSettingAssocCollection(name: "aarraySetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingAssocCollection'];
        $I->assertSame('aarraySetting', $setting['name']);
        $I->assertSame('{"first":"10","second":"20","third":"50"}', $setting['value']);
    }

    public function testGetThemeSettingsListNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query getSettings($themeId: String!){
                themeSettingsList(themeId:  $themeId) {
                    name
                    type
                    supported
                }
            }',
            ['themeId' => $this->getTestThemeName()]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "themeSettingsList" on type "Query".', $errorMessage);
    }

    public function testGetThemeSettingsListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query getSettings($themeId: String!){
                themeSettingsList(themeId:  $themeId) {
                    name
                    type
                    supported
                }
            }',
            ['themeId' => $this->getTestThemeName()]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $settingsList = $result['data']['themeSettingsList'];
        $I->assertCount(7, $settingsList);
        $I->assertContains(
            ['name' => 'intSetting', 'type' => FieldType::NUMBER, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'floatSetting', 'type' => FieldType::NUMBER, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'boolSetting', 'type' => FieldType::BOOLEAN, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'stringSetting', 'type' => FieldType::STRING, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'selectSetting', 'type' => FieldType::SELECT, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'arraySetting', 'type' => FieldType::ARRAY, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'aarraySetting', 'type' => FieldType::ASSOCIATIVE_ARRAY, 'supported' => true],
            $settingsList
        );
    }

    public function testChangeIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingInteger(name: "intSettingEditable", value: 124, themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeThemeSettingInteger" on type "Mutation".', $errorMessage);
    }

    public function testChangeIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingInteger(name: "intSettingEditable", value: 124, themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeThemeSettingInteger'];
        $I->assertSame('intSettingEditable', $setting['name']);
        $I->assertSame(124, $setting['value']);
    }

    public function testChangeFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingFloat(name: "floatSettingEditable", value: 1.24, themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeThemeSettingFloat" on type "Mutation".', $errorMessage);
    }

    public function testChangeFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingFloat(name: "floatSettingEditable", value: 1.24, themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeThemeSettingFloat'];
        $I->assertSame('floatSettingEditable', $setting['name']);
        $I->assertSame(1.24, $setting['value']);
    }

    public function testChangeBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingBoolean(name: "boolSettingEditable", value: False, themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeThemeSettingBoolean" on type "Mutation".', $errorMessage);
    }

    public function testChangeBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingBoolean(name: "boolSettingEditable", value: true, themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeThemeSettingBoolean'];
        $I->assertSame('boolSettingEditable', $setting['name']);
        $I->assertSame(true, $setting['value']);
    }

    public function testChangeStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingString(name: "stringSettingEditable", value: "default", themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeThemeSettingString" on type "Mutation".', $errorMessage);
    }

    public function testChangeStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingString(name: "stringSetting", value: "default", themeId: "' . $this->getTestThemeName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeThemeSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testChangeCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingCollection(name: "arraySetting", themeId: "' . $this->getTestThemeName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeThemeSettingCollection" on type "Mutation".', $errorMessage);
    }

    public function testChangeCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeThemeSettingCollection(name: "arraySetting", themeId: "' . $this->getTestThemeName() . '", value: "[3, \"interesting\", \"values\"]") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeThemeSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('[3, "interesting", "values"]', $setting['value']);
    }
}
