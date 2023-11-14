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
 * @group theme_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ThemeSettingListCest extends BaseCest
{
    public function testGetThemeSettingsListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());
        $I->sendGQLQuery(
            'query getSettings($themeId: String!){
                    themeSettingsList(themeId:  $themeId) {
                      name
                      type
                      supported
                    }
                  }',
            ['themeId' => $this->getTestThemeName()]
        );
        $I->seeResponseIsJson();
        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);
        $settingsList = $result['data']['themeSettingsList'];
        $I->assertCount(14, $settingsList);
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
            ['name' => 'selectSetting', 'type' => FieldType::SELECT, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'arraySetting', 'type' => FieldType::ARRAY, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'aarraySetting', 'type' => FieldType::ASSOCIATIVE_ARRAY, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'intSettingEditable', 'type' => FieldType::NUMBER, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'floatSettingEditable', 'type' => FieldType::NUMBER, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'boolSettingEditable', 'type' => FieldType::BOOLEAN, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'stringSettingEditable', 'type' => FieldType::STRING, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'selectSettingEditable', 'type' => FieldType::SELECT, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'arraySettingEditable', 'type' => FieldType::ARRAY, 'supported' => true],
            $settingsList
        );
        $I->assertContains(
            ['name' => 'assocArraySettingEditable', 'type' => FieldType::ASSOCIATIVE_ARRAY, 'supported' => true],
            $settingsList
        );
    }
}
