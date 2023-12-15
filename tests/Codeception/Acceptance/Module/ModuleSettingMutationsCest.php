<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Module;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ModuleSettingMutationsCest extends ModuleSettingBaseCest
{
    public function testChangeIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: Int!, $moduleId: String!){
                moduleSettingIntegerChange(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => 'intSetting',
                'value' => 124,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingIntegerChange'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(124, $setting['value']);
    }

    public function testChangeFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: Float!, $moduleId: String!){
                moduleSettingFloatChange(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => 'floatSetting',
                'value' => 1.24,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingFloatChange'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.24, $setting['value']);
    }

    public function testChangeBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: Boolean!, $moduleId: String!){
                moduleSettingBooleanChange(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => 'boolSetting',
                'value' => false,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingBooleanChange'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    public function testChangeStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: String!, $moduleId: String!){
                moduleSettingStringChange(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => 'stringSetting',
                'value' => 'default',
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingStringChange'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testChangeCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: String!, $moduleId: String!){
                moduleSettingCollectionChange(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => 'arraySetting',
                'value' => '[3, "interesting", "values"]',
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingCollectionChange'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('[3,"interesting","values"]', $setting['value']);
    }
}
