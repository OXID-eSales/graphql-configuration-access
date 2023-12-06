<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ShopConfigurationDao;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ShopConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

abstract class ModuleSettingBaseCest extends BaseCest
{
    public function _before(AcceptanceTester $I): void
    {
        $this->prepareConfiguration();
    }

    protected function prepareConfiguration(): void
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
            ->setId(self::TEST_MODULE_ID)
            ->setModuleSource('testPath')
            ->addModuleSetting($integerSetting)
            ->addModuleSetting($floatSetting)
            ->addModuleSetting($booleanSetting)
            ->addModuleSetting($stringSetting)
            ->addModuleSetting($collectionSetting);

        $shopConfiguration->addModuleConfiguration($moduleConfiguration);
        $this->getShopConfigurationDao()->save($shopConfiguration, 1);
    }

    protected function getShopConfiguration(): ShopConfiguration
    {
        $shopConfigurationDao = $this->getShopConfigurationDao();
        $shopConfiguration = $shopConfigurationDao->get(1);

        return $shopConfiguration;
    }

    public function _after(AcceptanceTester $I): void
    {
        $this->removeConfiguration(self::TEST_MODULE_ID);
        BaseCest::_after($I);
    }

    protected function removeConfiguration(string $moduleId): void
    {
        $shopConfiguration = $this->getShopConfiguration();
        $shopConfiguration->deleteModuleConfiguration($moduleId);
    }

    protected function getShopConfigurationDao(): ShopConfigurationDao
    {
        $container = ContainerFactory::getInstance()->getContainer();
        /** @var ShopConfigurationDao $shopConfigurationDao */
        $shopConfigurationDao = $container->get(ShopConfigurationDaoInterface::class);
        return $shopConfigurationDao;
    }
}
