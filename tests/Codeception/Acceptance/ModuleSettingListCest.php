<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ModuleSettingListCest extends ModuleSettingBaseCest
{
    public function testGetModuleSettingsListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query getSettings($moduleId: String!){
                moduleSettingsList(moduleId:  $moduleId) {
                    name
                    type
                    supported
                }
            }',
            ['moduleId' => self::TEST_MODULE_ID]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $settingsList = $result['data']['moduleSettingsList'];
        $I->assertCount(5, $settingsList);
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
            ['name' => 'arraySetting', 'type' => FieldType::ARRAY, 'supported' => true],
            $settingsList
        );
    }
}
