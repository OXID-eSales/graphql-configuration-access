<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use Doctrine\DBAL\Connection;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForShopException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository
 */
class ShopSettingRepositoryTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addConfigItem('id1', 3, '', 'var1', 'type1', 'value1');
        $this->addConfigItem('id2', 3, '', 'var2', 'type2', 'value2');
        $this->addConfigItem('id3', 3, '', 'var3', 'type3', 'value3');
    }

    public function testGetSettingsList(): void
    {
        $sut = $this->getSutForShop(3);

        $this->assertEquals(
            [
                'var1' => 'type1',
                'var2' => 'type2',
                'var3' => 'type3',
            ],
            $sut->getSettingsList()
        );
    }

    public function testGetSettingsListOnNoSettingsThrowsException(): void
    {
        $sut = $this->getSutForShop(2);

        $this->expectException(NoSettingsFoundForShopException::class);
        $sut->getSettingsList();
    }

    private function getDbConnection(): Connection
    {
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);
        $connection = $queryBuilderFactory->create()->getConnection();

        return $connection;
    }

    private function addConfigItem($oxid, $shopId, $module, $varName, $varType, $value): void
    {
        $connection = $this->getDbConnection();

        $query = "insert into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue)
                  values (:oxid, :oxshopid, :oxmodule, :oxvarname, :oxvartype, :value)";
        $connection->executeQuery($query, [
            ':oxid' => $oxid,
            ':oxshopid' => $shopId,
            ':oxmodule' => $module,
            ':oxvarname' => $varName,
            ':oxvartype' => $varType,
            ':value' => $value,
        ]);
    }

    public function getSutForShop(int $shopId): ShopSettingRepository
    {
        $basicContext = $this->createStub(BasicContextInterface::class);
        $basicContext->method('getCurrentShopId')->willReturn($shopId);

        $sut = new ShopSettingRepository(
            basicContext: $basicContext,
            eventDispatcher: $this->get(EventDispatcherInterface::class),
            queryBuilderFactory: $this->get(QueryBuilderFactoryInterface::class),
            shopSettingEncoder: $this->get(ShopSettingEncoderInterface::class),
            configurationSettingDao: $this->get(ShopConfigurationSettingDaoInterface::class)
        );

        return $sut;
    }
}
