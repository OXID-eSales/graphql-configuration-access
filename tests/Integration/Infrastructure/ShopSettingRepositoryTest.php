<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use Doctrine\DBAL\Connection;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Dao\EntryDoesNotExistDaoException;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception\NoSettingsFoundForShopException;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Infrastructure\ShopSettingRepository;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shop\Infrastructure\ShopSettingRepository
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

    /**
     * @dataProvider exceptionGetterDataProvider
     */
    public function testGetterExceptionIfSettingNotExist(string $getterMethod): void
    {
        $sut = $this->getSutForShop(2);

        $this->expectException(EntryDoesNotExistDaoException::class);
        $this->expectExceptionMessage('Setting NotExistant doesn\'t exist in the shop with id 2');
        $sut->$getterMethod('NotExistant');
    }

    public function exceptionGetterDataProvider(): \Generator
    {
        yield ['getInteger'];
        yield ['getFloat'];
        yield ['getBoolean'];
        yield ['getString'];
        yield ['getSelect'];
        yield ['getCollection'];
        yield ['getAssocCollection'];
    }

    /**
     * @dataProvider exceptionSetterDataProvider
     */
    public function testSetterExceptionIfSettingNotExist(string $setterMethod, mixed $value): void
    {
        $sut = $this->getSutForShop(2);

        $this->expectException(EntryDoesNotExistDaoException::class);
        $this->expectExceptionMessage('Setting NotExistant doesn\'t exist in the shop with id 2');
        $sut->$setterMethod('NotExistant', $value);
    }

    public function exceptionSetterDataProvider(): \Generator
    {
        yield [
            'setterMethod' => 'saveIntegerSetting',
            'value' => 123
        ];
        yield [
            'setterMethod' => 'saveFloatSetting',
            'value' => 1.23
        ];
        yield [
            'setterMethod' => 'saveBooleanSetting',
            'value' => true
        ];
        yield [
            'setterMethod' => 'saveStringSetting',
            'value' => 'string'
        ];
        yield [
            'setterMethod' => 'saveSelectSetting',
            'value' => 'select'
        ];
        yield [
            'setterMethod' => 'saveCollectionSetting',
            'value' => ['nice', 'collection']
        ];
        yield [
            'setterMethod' => 'saveAssocCollectionSetting',
            'value' => ['first' => 'nice', 'second' => 'collection']
        ];
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
        $context = $this->createStub(ContextInterface::class);
        $context->method('getCurrentShopId')->willReturn($shopId);

        $sut = new ShopSettingRepository(
            context: $context,
            queryBuilderFactory: $this->get(QueryBuilderFactoryInterface::class),
            configurationSettingDao: $this->get(ShopConfigurationSettingDaoInterface::class)
        );

        return $sut;
    }
}
