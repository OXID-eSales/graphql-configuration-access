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
 * @group theme_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ThemeSettingGettersCest extends BaseCest
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
            'queryName' => 'themeSettingInteger',
            'settingName' => 'intSetting',
            'expectedValue' => 123
        ];

        yield [
            'queryName' => 'themeSettingFloat',
            'settingName' => 'floatSetting',
            'expectedValue' => 1.23
        ];

        yield [
            'queryName' => 'themeSettingBoolean',
            'settingName' => 'boolSetting',
            'expectedValue' => false
        ];

        yield [
            'queryName' => 'themeSettingString',
            'settingName' => 'stringSetting',
            'expectedValue' => 'default'
        ];

        yield [
            'queryName' => 'themeSettingSelect',
            'settingName' => 'selectSetting',
            'expectedValue' => 'selectString'
        ];

        yield [
            'queryName' => 'themeSettingCollection',
            'settingName' => 'arraySetting',
            'expectedValue' => '["10","20","50","100"]'
        ];

        yield [
            'queryName' => 'themeSettingAssocCollection',
            'settingName' => 'aarraySetting',
            'expectedValue' => '{"first":"10","second":"20","third":"50"}'
        ];
    }

    private function runSettingGetterQuery(AcceptanceTester $I, string $queryName, string $settingName): array
    {
        $I->sendGQLQuery(
            'query q($name: String!, $themeId: String!){
                ' . $queryName . '(name: $name, themeId: $themeId) {
                    name
                    value
                }
            }',
            [
                'name' => $settingName,
                'themeId' => self::TEST_THEME_ID
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }
}
