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

        $result = $this->runGetIntegerQueryAndGetResult($I, 'intSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingInteger');
    }

    public function testGetIntegerSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runGetIntegerQueryAndGetResult($I, 'intSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingInteger'];
        $I->assertSame('intSetting', $setting['name']);
        $I->assertSame(123, $setting['value']);
    }

    private function runGetIntegerQueryAndGetResult(AcceptanceTester $I, string $name): array
    {
        $I->sendGQLQuery(
            'query q($name: ID!, $moduleId: String!){
                moduleSettingInteger(name: $name, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testGetFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runGetFloatQueryAndGetResult($I, 'floatSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingFloat');
    }

    public function testGetFloatSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runGetFloatQueryAndGetResult($I, 'floatSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingFloat'];
        $I->assertSame('floatSetting', $setting['name']);
        $I->assertSame(1.23, $setting['value']);
    }

    private function runGetFloatQueryAndGetResult(AcceptanceTester $I, string $name): array
    {
        $I->sendGQLQuery(
            'query q($name: ID!, $moduleId: String!){
                moduleSettingFloat(name: $name, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testGetBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runGetBooleanQueryAndGetResult($I, 'boolSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingBoolean');
    }

    public function testGetBooleanSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runGetBooleanQueryAndGetResult($I, 'boolSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingBoolean'];
        $I->assertSame('boolSetting', $setting['name']);
        $I->assertSame(false, $setting['value']);
    }

    private function runGetBooleanQueryAndGetResult(AcceptanceTester $I, string $name): array
    {
        $I->sendGQLQuery(
            'query q($name: ID!, $moduleId: String!){
                moduleSettingBoolean(name: $name, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testGetStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runGetStringQueryAndGetResult($I, 'stringSetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingString');
    }

    public function testGetStringSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runGetStringQueryAndGetResult($I, 'stringSetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingString'];
        $I->assertSame('stringSetting', $setting['name']);
        $I->assertSame('default', $setting['value']);
    }

    private function runGetStringQueryAndGetResult(AcceptanceTester $I, string $name): array
    {
        $I->sendGQLQuery(
            'query q($name: ID!, $moduleId: String!){
                moduleSettingString(name: $name, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testGetCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runGetCollectionQueryAndGetResult($I, 'arraySetting');

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingCollection');
    }

    public function testGetCollectionSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runGetCollectionQueryAndGetResult($I, 'arraySetting');

        $I->assertArrayNotHasKey('errors', $result);

        $setting = $result['data']['moduleSettingCollection'];
        $I->assertSame('arraySetting', $setting['name']);
        $I->assertSame('["nice","values"]', $setting['value']);
    }

    private function runGetCollectionQueryAndGetResult(AcceptanceTester $I, string $name): array
    {
        $I->sendGQLQuery(
            'query q($name: ID!, $moduleId: String!){
                moduleSettingCollection(name: $name, moduleId: $moduleId) {
                    name
                    value
                }
            }',
            [
                'name' => $name,
                'moduleId' => $this->getTestModuleName()
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
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeFloatSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runFloatMutationAndGetResult($I, 'floatSetting', 1.24);

        $this->assertMutationNotFoundErrorInResult($I, $result, 'changeModuleSettingFloat');
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
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeBooleanSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runChangeBooleanMutationAndGetResult($I, 'boolSetting', false);

        $this->assertMutationNotFoundErrorInResult($I, $result, 'changeModuleSettingBoolean');
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
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeStringSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runChangeStringMutationAndGetResult($I, 'stringSetting', 'default');

        $this->assertMutationNotFoundErrorInResult($I, $result, 'changeModuleSettingString');
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
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    public function testChangeCollectionSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runChangeCollectionMutationAndGetResult($I, 'arraySetting', '[3, "interesting", "values"]');

        $this->assertMutationNotFoundErrorInResult($I, $result, 'changeModuleSettingCollection');
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
                'moduleId' => $this->getTestModuleName()
            ]
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
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

        $this->assertQueryNotFoundErrorInResult($I, $result, 'moduleSettingsList');
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
