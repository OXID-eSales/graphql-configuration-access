<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Basket;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ShopConfigurationDao;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ShopConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ModuleSettingCest extends BaseCest
{
    public function _before(AcceptanceTester $I): void
    {
        $this->prepareConfiguration();
    }

    public function _after(AcceptanceTester $I): void
    {
        $this->removeConfiguration($this->getTestModuleName());
        parent::_after($I);
    }

    public function testGetIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "intSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingInteger" on type "Query".', $errorMessage);
    }

    public function testGetIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "intSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(123, $setting['value']);
    }

    public function testGetFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingFloat(name: "floatSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingFloat" on type "Query".', $errorMessage);
    }

    public function testGetFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingFloat(name: "floatSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.23, $setting['value']);
    }

    public function testGetBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingBoolean(name: "boolSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingBoolean" on type "Query".', $errorMessage);
    }

    public function testGetBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingBoolean(name: "boolSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    public function testGetStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingString(name: "stringSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingString" on type "Query".', $errorMessage);
    }

    public function testGetStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingString(name: "stringSetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testGetCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingCollection(name: "arraySetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingCollection" on type "Query".', $errorMessage);
    }

    public function testGetCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'query{
                moduleSettingCollection(name: "arraySetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('["nice","values"]', $setting['value']);
    }

    public function testChangeIntegerSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingInteger(name: "intSetting", value: 124, moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeModuleSettingInteger" on type "Mutation".', $errorMessage);
    }

    public function testChangeIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingInteger(name: "intSetting", value: 124, moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(124, $setting['value']);
    }

    public function testChangeFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingFloat(name: "floatSetting", value: 1.24, moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeModuleSettingFloat" on type "Mutation".', $errorMessage);
    }

    public function testChangeFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingFloat(name: "floatSetting", value: 1.24, moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.24, $setting['value']);
    }

    public function testChangeBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingBoolean(name: "boolSetting", value: False, moduleId: "' . $this->getTestModuleName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeModuleSettingBoolean" on type "Mutation".', $errorMessage);
    }

    public function testChangeBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingBoolean(name: "boolSetting", value: false, moduleId: "' . $this->getTestModuleName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    public function testChangeStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingString(name: "stringSetting", value: "default", moduleId: "' . $this->getTestModuleName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeModuleSettingString" on type "Mutation".', $errorMessage);
    }

    public function testChangeStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingString(name: "stringSetting", value: "default", moduleId: "' . $this->getTestModuleName(
            ) . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    public function testChangeCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingCollection(name: "arraySetting", moduleId: "' . $this->getTestModuleName() . '") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "changeModuleSettingCollection" on type "Mutation".', $errorMessage);
    }

    public function testChangeCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $I->sendGQLQuery(
            'mutation{
                changeModuleSettingCollection(name: "arraySetting", moduleId: "' . $this->getTestModuleName() . '", value: "[3, \"interesting\", \"values\"]") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['changeModuleSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('[3, "interesting", "values"]', $setting['value']);
    }

    public function testGetModuleSettingsListNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $I->sendGQLQuery(
            'query getSettings($moduleId: String!){
                moduleSettingsList(moduleId:  $moduleId) {
                    name
                    type
                }
            }',
            ['moduleId' => $this->getTestModuleName()]
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame('Cannot query field "moduleSettingsList" on type "Query".', $errorMessage);
    }

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
            ['moduleId' => $this->getTestModuleName()]
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

    private function prepareConfiguration(): void
    {
        $shopConfiguration = $this->getShopConfiguration();

        $integerSetting = new Setting();
        $integerSetting
            ->setName('intSetting')
            ->setValue(123)
            ->setType(FieldType::NUMBER);

        $floatSetting = new Setting();
        $floatSetting
            ->setName('floatSetting')
            ->setValue(1.23)
            ->setType(FieldType::NUMBER);

        $booleanSetting = new Setting();
        $booleanSetting
            ->setName('boolSetting')
            ->setValue(false)
            ->setType(FieldType::BOOLEAN);

        $stringSetting = new Setting();
        $stringSetting
            ->setName('stringSetting')
            ->setValue('default')
            ->setType(FieldType::STRING);

        $collectionSetting = new Setting();
        $collectionSetting
            ->setName('arraySetting')
            ->setValue(['nice', 'values'])
            ->setType(FieldType::ARRAY);


        $moduleConfiguration = new ModuleConfiguration();
        $moduleConfiguration
            ->setId($this->getTestModuleName())
            ->setModuleSource('testPath')
            ->addModuleSetting($integerSetting)
            ->addModuleSetting($floatSetting)
            ->addModuleSetting($booleanSetting)
            ->addModuleSetting($stringSetting)
            ->addModuleSetting($collectionSetting);

        $shopConfiguration->addModuleConfiguration($moduleConfiguration);
        $this->getShopConfigurationDao()->save($shopConfiguration, 1);
    }

    private function removeConfiguration(string $moduleId): void
    {
        $shopConfiguration = $this->getShopConfiguration();
        $shopConfiguration->deleteModuleConfiguration($moduleId);
    }

    private function getShopConfiguration(): ShopConfiguration
    {
        $shopConfigurationDao = $this->getShopConfigurationDao();
        $shopConfiguration = $shopConfigurationDao->get(1);

        return $shopConfiguration;
    }

    private function getShopConfigurationDao(): ShopConfigurationDao
    {
        $container = ContainerFactory::getInstance()->getContainer();
        /** @var ShopConfigurationDao $shopConfigurationDao */
        $shopConfigurationDao = $container->get(ShopConfigurationDaoInterface::class);
        return $shopConfigurationDao;
    }
}
