<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Basket;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\ModuleSettingBaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ModuleSettingQueriesCest extends ModuleSettingBaseCest
{
    public function testGetIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingInteger', 'intSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingInteger');
    }

    public function testGetIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingInteger', 'intSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(123, $setting['value']);
    }

    public function testGetFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingFloat', 'floatSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingFloat');
    }

    public function testGetFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingFloat', 'floatSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.23, $setting['value']);
    }

    public function testGetBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingBoolean', 'boolSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingBoolean');
    }

    public function testGetBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingBoolean', 'boolSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    public function testGetStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingString', 'stringSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingString');
    }

    public function testGetStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingString', 'stringSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testGetCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingCollection', 'arraySetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingCollection');
    }

    public function testGetCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runSettingGetterQuery($I, 'moduleSettingCollection', 'arraySetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('["nice","values"]', $setting['value']);
    }

    private function runSettingGetterQuery(AcceptanceTester $I, string $queryName, string $settingName): array
    {
        $I->sendGQLQuery(
            'query q($name: ID!, $moduleId: String!){
                ' . $queryName . '(name: $name, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $settingName,
                'moduleId' => self::TEST_MODULE_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runChangeIntegerMutationAndGetResult($I, 'intSetting', 124);

        $this->assertMutationNotFoundErrorInResult($I, $result, 'changeModuleSettingInteger');
    }

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
}
