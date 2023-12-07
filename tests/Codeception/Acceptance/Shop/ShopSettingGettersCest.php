<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Shop;

use Codeception\Attribute\DataProvider;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group shop_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ShopSettingGettersCest extends BaseCest
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
            'queryName' => 'shopSettingInteger',
            'settingName' => 'intSetting',
            'expectedValue' => 123
        ];

        yield [
            'queryName' => 'shopSettingFloat',
            'settingName' => 'floatSetting',
            'expectedValue' => 1.23
        ];

        yield [
            'queryName' => 'shopSettingBoolean',
            'settingName' => 'boolSetting',
            'expectedValue' => false
        ];

        yield [
            'queryName' => 'shopSettingString',
            'settingName' => 'stringSetting',
            'expectedValue' => 'default'
        ];

        yield [
            'queryName' => 'shopSettingSelect',
            'settingName' => 'selectSetting',
            'expectedValue' => 'selectString'
        ];

        yield [
            'queryName' => 'shopSettingCollection',
            'settingName' => 'arraySetting',
            'expectedValue' => '["10","20","50","100"]'
        ];

        yield [
            'queryName' => 'shopSettingAssocCollection',
            'settingName' => 'aarraySetting',
            'expectedValue' => '{"first":"10","second":"20","third":"50"}'
        ];
    }

    private function runSettingGetterQuery(AcceptanceTester $I, string $queryName, string $settingName): array
    {
        $I->sendGQLQuery(
            'query q($name: String!){
                ' . $queryName . '(name: $name) {
                    name
                    value
                }
            }',
            [
                'name' => $settingName
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }
}
