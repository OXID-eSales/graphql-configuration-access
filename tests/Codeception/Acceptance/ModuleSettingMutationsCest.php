<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

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

        $result = $this->runChangeIntegerMutationAndGetResult($I, 'intSetting', 124);

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(124, $setting['value']);
    }

    private function runChangeIntegerMutationAndGetResult(AcceptanceTester $I, string $name, int $value): array
    {
        $I->sendGQLQuery(
            'mutation m($name: ID!, $value: Int!, $moduleId: String!){
                changeModuleSettingInteger(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'value' => $value,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runFloatMutationAndGetResult($I, 'floatSetting', 1.24);
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.24, $setting['value']);
    }

    private function runFloatMutationAndGetResult(AcceptanceTester $I, string $name, float $value): array
    {
        $I->sendGQLQuery(
            'mutation m($name: ID!, $value: Float!, $moduleId: String!){
                changeModuleSettingFloat(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'value' => $value,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runChangeBooleanMutationAndGetResult($I, 'boolSetting', false);

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    private function runChangeBooleanMutationAndGetResult(AcceptanceTester $I, string $name, bool $value): array
    {
        $I->sendGQLQuery(
            'mutation m($name: ID!, $value: Boolean!, $moduleId: String!){
                changeModuleSettingBoolean(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'value' => $value,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runChangeStringMutationAndGetResult($I, 'stringSetting', 'default');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    private function runChangeStringMutationAndGetResult(AcceptanceTester $I, string $name, string $value): array
    {
        $I->sendGQLQuery(
            'mutation m($name: ID!, $value: String!, $moduleId: String!){
                changeModuleSettingString(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'value' => $value,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runChangeCollectionMutationAndGetResult($I, 'arraySetting', '[3, "interesting", "values"]');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('[3, "interesting", "values"]', $setting['value']);
    }

    private function runChangeCollectionMutationAndGetResult(AcceptanceTester $I, string $name, string $value): array
    {
        $I->sendGQLQuery(
            'mutation m($name: ID!, $value: String!, $moduleId: String!){
                changeModuleSettingCollection(name: $name, value: $value, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'value' => $value,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }
}
