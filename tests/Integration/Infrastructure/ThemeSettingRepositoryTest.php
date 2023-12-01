<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Theme\Event\ThemeSettingChangedEvent;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForThemeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository
 */
class ThemeSettingRepositoryTest extends IntegrationTestCase
{
    public function testSaveAndGetIntegerSetting(): void
    {
        $name = 'coolIntSetting';
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::NUMBER,
            123
        );

        $repository->saveIntegerSetting(new ID($name), 124, 'awesomeTheme');
        $integerResult = $repository->getInteger(new ID($name), 'awesomeTheme');

        $this->assertSame(124, $integerResult);
    }

    public function testSaveAndGetFloatSetting(): void
    {
        $name = "coolFloatSetting";
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::NUMBER,
            1.23
        );

        $repository->saveFloatSetting(new ID($name), 1.24, 'awesomeTheme');
        $floatResult = $repository->getFloat(new ID($name), 'awesomeTheme');

        $this->assertSame(1.24, $floatResult);
    }

    public function testSaveAndGetBooleanSetting(): void
    {
        $name = "coolBooleanSetting";
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::BOOLEAN,
            ''
        );

        $repository->saveBooleanSetting(new ID($name), true, 'awesomeTheme');
        $floatResult = $repository->getBoolean(new ID($name), 'awesomeTheme');

        $this->assertSame(true, $floatResult);
    }

    public function testSaveAndGetStringSetting(): void
    {
        $name = 'coolStringSetting';
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::STRING,
            'default'
        );

        $repository->saveStringSetting(new ID($name), 'new value', 'awesomeTheme');
        $stringResult = $repository->getString(new ID($name), 'awesomeTheme');

        $this->assertSame('new value', $stringResult);
    }

    public function testSaveAndGetSelectSetting(): void
    {
        $name = 'coolSelectSetting';
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::SELECT,
            'select'
        );

        $repository->saveSelectSetting(new ID($name), 'new select value', 'awesomeTheme');
        $stringResult = $repository->getSelect(new ID($name), 'awesomeTheme');

        $this->assertSame('new select value', $stringResult);
    }

    public function testSaveAndGetCollectionSetting(): void
    {
        $name = 'coolArraySetting';
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::ARRAY,
            'a:2:{i:0;s:4:"nice";i:1;s:6:"values";}'
        );

        $repository->saveCollectionSetting(new ID($name), ['nice', 'cool', 'values'], 'awesomeTheme');
        $collectionResult = $repository->getCollection(new ID($name), 'awesomeTheme');

        $this->assertSame(['nice', 'cool', 'values'], $collectionResult);
    }

    public function testSaveAndGetAssocCollectionSetting(): void
    {
        $name = 'coolAssocArraySetting';
        $eventDispatcher = $this->getEventDispatcherMock($name);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

        $repository = $this->getSut(
            eventDispatcher: $eventDispatcher,
            queryBuilderFactory: $queryBuilderFactory
        );

        $this->createThemeSetting(
            $queryBuilderFactory,
            $name,
            FieldType::ASSOCIATIVE_ARRAY,
            'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}'
        );

        $repository->saveAssocCollectionSetting(
            new ID($name),
            ['first' => '10', 'second' => '20', 'third' => '60'],
            'awesomeTheme'
        );
        $assocCollectionResult = $repository->getAssocCollection(new ID($name), 'awesomeTheme');

        $this->assertSame(['first' => '10', 'second' => '20', 'third' => '60'], $assocCollectionResult);
    }

    private function getSut(
        ?BasicContextInterface $basicContext = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $shopSettingEncoder = null
    ): ThemeSettingRepository {
        return new ThemeSettingRepository(
            $basicContext ?? $this->get(BasicContextInterface::class),
            $eventDispatcher ?? $this->get(EventDispatcherInterface::class),
            $queryBuilderFactory ?? $this->get(QueryBuilderFactoryInterface::class),
            $shopSettingEncoder ?? $this->get(ShopSettingEncoderInterface::class)
        );
    }

    private function createThemeSetting(
        QueryBuilderFactoryInterface $queryBuilderFactory,
        string $name,
        string $fieldType,
        mixed $value
    ): void {
        $uniqueId = uniqid();
        $queryBuilder = $queryBuilderFactory->create();
        $queryBuilder
            ->insert('oxconfig')
            ->values([
                'oxid' => ':oxid',
                'oxshopid' => ':oxshopid',
                'oxmodule' => ':oxmodule',
                'oxvarname' => ':oxvarname',
                'oxvartype' => ':oxvartype',
                'oxvarvalue' => ':oxvarvalue',
            ])
            ->setParameters([
                'oxid' => $uniqueId,
                'oxshopid' => 1,
                'oxmodule' => 'theme:awesomeTheme',
                'oxvarname' => $name,
                'oxvartype' => $fieldType,
                'oxvarvalue' => $value
            ]);
        $queryBuilder->execute();
    }

    private function getEventDispatcherMock(string $name): EventDispatcherInterface
    {
        $configurationChangedEvent = new ThemeSettingChangedEvent(
            $name,
            1,
            'awesomeTheme'
        );
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($configurationChangedEvent);
        return $eventDispatcher;
    }
}
