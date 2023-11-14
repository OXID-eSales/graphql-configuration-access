<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

use Codeception\Attribute\DataProvider;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ModuleSettingGettersCest extends ModuleSettingBaseCest
{
    #[DataProvider('queryMethodsDataProvider')]
    public function testGetSettingAuthorized(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runSettingGetterQuery($I, $example['queryName'], $example['settingName']);

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data'][$example['queryName']];
        $I->assertSame($example['settingName'], $setting['name']);
        $I->assertSame($example['expectedValue'], $setting['value']);
    }

    protected function queryMethodsDataProvider(): \Generator
    {
        yield [
            'queryName' => 'moduleSettingInteger',
            'settingName' => 'intSetting',
            'expectedValue' => 123
        ];

        yield [
            'queryName' => 'moduleSettingFloat',
            'settingName' => 'floatSetting',
            'expectedValue' => 1.23
        ];

        yield [
            'queryName' => 'moduleSettingBoolean',
            'settingName' => 'boolSetting',
            'expectedValue' => false
        ];

        yield [
            'queryName' => 'moduleSettingString',
            'settingName' => 'stringSetting',
            'expectedValue' => 'default'
        ];

        yield [
            'queryName' => 'moduleSettingCollection',
            'settingName' => 'arraySetting',
            'expectedValue' => '["nice","values"]'
        ];
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
}
