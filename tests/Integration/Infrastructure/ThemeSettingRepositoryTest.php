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
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

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

    public function testSaveNotExistingIntegerSetting(): void
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->never())
            ->method('dispatch');
        $repository = $this->getSut(eventDispatcher: $eventDispatcher);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Configuration "notExistingSetting" was not found for awesomeTheme');
        $repository->saveIntegerSetting(new ID('notExistingSetting'), 1234, 'awesomeTheme');
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

    public function testSaveNotExistingFloatSetting(): void
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->never())
            ->method('dispatch');
        $repository = $this->getSut(eventDispatcher: $eventDispatcher);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Configuration "notExistingSetting" was not found for awesomeTheme');
        $repository->saveFloatSetting(new ID('notExistingSetting'), 1234, 'awesomeTheme');
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

    public function testSaveNotExistingBooleanSetting(): void
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->never())
            ->method('dispatch');
        $repository = $this->getSut(eventDispatcher: $eventDispatcher);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Configuration "notExistingSetting" was not found for awesomeTheme');
        $repository->saveBooleanSetting(new ID('notExistingSetting'), true, 'awesomeTheme');
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

    public function testSaveNotExistingStringSetting(): void
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->never())
            ->method('dispatch');
        $repository = $this->getSut(eventDispatcher: $eventDispatcher);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Configuration "notExistingSetting" was not found for awesomeTheme');
        $repository->saveStringSetting(new ID('notExistingSetting'), 'new value', 'awesomeTheme');
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

    public function testSaveNotExistingSelectSetting(): void
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->never())
            ->method('dispatch');
        $repository = $this->getSut(eventDispatcher: $eventDispatcher);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Configuration "notExistingSetting" was not found for awesomeTheme');
        $repository->saveSelectSetting(new ID('notExistingSetting'), 'new value', 'awesomeTheme');
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

        $this->assertSame(['nice','cool','values'], $collectionResult);
    }

    public function testSaveNotExistingCollectionSetting(): void
    {
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->never())
            ->method('dispatch');
        $repository = $this->getSut(eventDispatcher: $eventDispatcher);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('Configuration "notExistingSetting" was not found for awesomeTheme');
        $repository->saveCollectionSetting(new ID('notExistingSetting'), ['nice', 'cool', 'values'], 'awesomeTheme');
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
            ->setValue('oxid', ':oxid')
            ->setValue('oxshopid', ':oxshopid')
            ->setValue('oxmodule', ':oxmodule')
            ->setValue('oxvarname', ':oxvarname')
            ->setValue('oxvartype', ':oxvartype')
            ->setValue('oxvarvalue', ':oxvarvalue')
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

    /**
     * @param string $name
     * @return MockObject|EventDispatcherInterface|(EventDispatcherInterface&MockObject)
     */
    public function getEventDispatcherMock(string $name): MockObject|EventDispatcherInterface
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
