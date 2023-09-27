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
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class SettingCest extends BaseCest
{
    private const AGENT_USERNAME = 'JanvierJaimesVelasquez@cuvox.de';

    private const AGENT_PASSWORD = 'agent';

    private const ADMIN_USERNAME = 'noreply@oxid-esales.com';

    private const ADMIN_PASSWORD = 'admin';

    private const TEST_MODULE_ID = 'awsomeModule';

    public function _beforeSuite(array $settings): void
    {
        $this->prepareConfiguration();
    }
    public function testGetSettingNotAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::AGENT_USERNAME, self::AGENT_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "intSetting", moduleId: "'.self::TEST_MODULE_ID.'") {
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

    public function testGetSettingAuthorized(AcceptanceTester $I): void
    {
        $I->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);

        $I->sendGQLQuery(
            'query{
                moduleSettingInteger(name: "intSetting", moduleId: "'.self::TEST_MODULE_ID.'") {
                    name
                    value
                }
            }'
        );

        $I->seeResponseIsJson();

        $result = $I->grabJsonResponseAsArray();
        $I->assertArrayNotHasKey('errors', $result);
    }

    private function prepareConfiguration(): void
    {
        $container = ContainerFactory::getInstance()->getContainer();
        /** @var ShopConfigurationDao $shopConfigurationDao */
        $shopConfigurationDao = $container->get(ShopConfigurationDaoInterface::class);
        $shopConfiguration = $shopConfigurationDao->get(1);

        $integerSetting = new Setting();
        $integerSetting
            ->setName('intSetting')
            ->setValue(123);

        $floatSetting = new Setting();
        $floatSetting
            ->setName('floatSetting')
            ->setValue(1.23);

        $booleanSetting = new Setting();
        $booleanSetting
            ->setName('boolSetting')
            ->setValue(false);

        $stringSetting = new Setting();
        $stringSetting
            ->setName('stringSetting')
            ->setValue('default');

        $collectionSetting = new Setting();
        $collectionSetting
            ->setName('arraySetting')
            ->setValue(['nice', 'values']);


        $moduleConfiguration = new ModuleConfiguration();
        $moduleConfiguration
            ->setId(self::TEST_MODULE_ID)
            ->setModuleSource('testPath')
            ->addModuleSetting($integerSetting)
            ->addModuleSetting($floatSetting)
            ->addModuleSetting($booleanSetting)
            ->addModuleSetting($stringSetting)
            ->addModuleSetting($collectionSetting);

        $shopConfiguration->addModuleConfiguration($moduleConfiguration);
        $shopConfigurationDao->save($shopConfiguration, 1);
    }
}
