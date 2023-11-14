<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group theme_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ThemeSettingMutationsCest extends BaseCest
{
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
