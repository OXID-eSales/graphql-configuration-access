<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Theme\Event\ThemeSettingChangedEvent;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingRepositoryTest extends IntegrationTestCase
{
    public function testSaveAndGetIntegerSetting(): void
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $configurationChangedEvent = new ThemeSettingChangedEvent(
            "coolIntSetting",
            1,
            'awesomeTheme'
        );
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($configurationChangedEvent);
        $basicContext = $container->get(BasicContextInterface::class);
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $container->get(QueryBuilderFactoryInterface::class);

        $repository = new ThemeSettingRepository(
            $basicContext,
            $eventDispatcher,
            $queryBuilderFactory
        );

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
                'oxvarname' => 'coolIntSetting',
                'oxvartype' => FieldType::NUMBER,
                'oxvarvalue' => 123
            ]);
        $queryBuilder->execute();

        $repository->saveIntegerSetting(new ID('coolIntSetting'), 124, 'awesomeTheme');
        $integerResult = $repository->getInteger(new ID('coolIntSetting'), 'awesomeTheme');

        $this->assertSame(124, $integerResult);
    }
}
