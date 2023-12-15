<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Theme;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
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
            'mutation m($name: String!, $value: Int!, $themeId: String!){
                themeSettingIntegerChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'intSettingEditable',
                'value' => 124,
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingIntegerChange'];
        $I->assertSame('intSettingEditable', $setting['name']);
        $I->assertSame(124, $setting['value']);
    }

    public function testChangeFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: Float!, $themeId: String!){
                themeSettingFloatChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'floatSettingEditable',
                'value' => 1.24,
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingFloatChange'];
        $I->assertSame('floatSettingEditable', $setting['name']);
        $I->assertSame(1.24, $setting['value']);
    }

    public function testChangeBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: Boolean!, $themeId: String!){
                themeSettingBooleanChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'boolSettingEditable',
                'value' => true,
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingBooleanChange'];
        $I->assertSame('boolSettingEditable', $setting['name']);
        $I->assertSame(true, $setting['value']);
    }

    public function testChangeStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: String!, $themeId: String!){
                themeSettingStringChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'stringSettingEditable',
                'value' => 'default',
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingStringChange'];
        $I->assertSame('stringSettingEditable', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testChangeSelectSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: String!, $themeId: String!){
                themeSettingSelectChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'selectSettingEditable',
                'value' => 'new select',
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingSelectChange'];
        $I->assertSame('selectSettingEditable', $setting['name']);
        $I->assertSame('new select', $setting['value']);
    }

    public function testChangeCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: String!, $themeId: String!){
                themeSettingCollectionChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'arraySettingEditable',
                'value' => '[3, "interesting", "values"]',
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingCollectionChange'];
        $I->assertSame('arraySettingEditable', $setting['name']);
        $I->assertSame('[3,"interesting","values"]', $setting['value']);
    }

    public function testChangeAssocCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: String!, $themeId: String!){
                themeSettingAssocCollectionChange(name: $name, value: $value, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => 'assocArraySettingEditable',
                'value' => '{"first":"10","second":"20","third":"50"}',
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['themeSettingAssocCollectionChange'];
        $I->assertSame('assocArraySettingEditable', $setting['name']);
        $I->assertSame('{"first":"10","second":"20","third":"50"}', $setting['value']);
    }
}
