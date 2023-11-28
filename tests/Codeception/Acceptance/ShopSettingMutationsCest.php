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
 * @group shop_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ShopSettingMutationsCest extends BaseCest
{
    #[DataProvider('mutationMethodsDataProvider')]
    public function testChangeSettingAuthorized(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation m($name: String!, $value: ' . $example['valueType'] . '){
                ' . $example['mutationName'] . '(name: $name, value: $value) {
                    name
                    value
                }
            }',
            [
                'name' => $example['settingName'],
                'value' => $example['settingValue']
            ]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data'][$example['mutationName']];
        $I->assertSame($example['settingName'], $setting['name']);
        $I->assertSame($example['settingValue'], $setting['value']);
    }

    protected function mutationMethodsDataProvider(): \Generator
    {
        yield [
            'mutationName' => 'changeShopSettingInteger',
            'settingName' => 'intSetting',
            'settingValue' => 235,
            'valueType' => 'Int!'
        ];

        yield [
            'mutationName' => 'changeShopSettingFloat',
            'settingName' => 'floatSetting',
            'settingValue' => 2.35,
            'valueType' => 'Float!'
        ];

        yield [
            'mutationName' => 'changeShopSettingBoolean',
            'settingName' => 'boolSetting',
            'settingValue' => true,
            'valueType' => 'Boolean!'
        ];

        yield [
            'mutationName' => 'changeShopSettingString',
            'settingName' => 'stringSetting',
            'settingValue' => 'some string value',
            'valueType' => 'String!'
        ];

        yield [
            'mutationName' => 'changeShopSettingSelect',
            'settingName' => 'selectSetting',
            'settingValue' => 'some select value',
            'valueType' => 'String!'
        ];

        yield [
            'mutationName' => 'changeShopSettingCollection',
            'settingName' => 'arraySetting',
            'settingValue' => '["10","20","50","100"]',
            'valueType' => 'String!'
        ];

        yield [
            'mutationName' => 'changeShopSettingAssocCollection',
            'settingName' => 'aarraySetting',
            'settingValue' => '{"first":"10","second":"20","third":"50"}',
            'valueType' => 'String!'
        ];
    }
}
