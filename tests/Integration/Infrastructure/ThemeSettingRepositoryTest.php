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

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::NUMBER,
            value: 123
        );

        $sut->saveIntegerSetting(new ID($name), 124, 'awesomeTheme');
        $integerResult = $sut->getInteger(new ID($name), 'awesomeTheme');

        $this->assertSame(124, $integerResult);
    }

    public function testSaveAndGetFloatSetting(): void
    {
        $name = "coolFloatSetting";

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::NUMBER,
            value: 1.23
        );

        $sut->saveFloatSetting(new ID($name), 1.24, 'awesomeTheme');
        $floatResult = $sut->getFloat(new ID($name), 'awesomeTheme');

        $this->assertSame(1.24, $floatResult);
    }

    public function testSaveAndGetBooleanSetting(): void
    {
        $name = "coolBooleanSetting";

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::BOOLEAN,
            value: ''
        );

        $sut->saveBooleanSetting(new ID($name), true, 'awesomeTheme');
        $floatResult = $sut->getBoolean(new ID($name), 'awesomeTheme');

        $this->assertSame(true, $floatResult);
    }

    public function testSaveAndGetStringSetting(): void
    {
        $name = 'coolStringSetting';

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::STRING,
            value: 'default'
        );

        $sut->saveStringSetting(new ID($name), 'new value', 'awesomeTheme');
        $stringResult = $sut->getString(new ID($name), 'awesomeTheme');

        $this->assertSame('new value', $stringResult);
    }

    public function testSaveAndGetSelectSetting(): void
    {
        $name = 'coolSelectSetting';

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::SELECT,
            value: 'select'
        );

        $sut->saveSelectSetting(new ID($name), 'new select value', 'awesomeTheme');
        $stringResult = $sut->getSelect(new ID($name), 'awesomeTheme');

        $this->assertSame('new select value', $stringResult);
    }

    public function testSaveAndGetCollectionSetting(): void
    {
        $name = 'coolArraySetting';

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::ARRAY,
            value: 'a:2:{i:0;s:4:"nice";i:1;s:6:"values";}'
        );

        $sut->saveCollectionSetting(new ID($name), ['nice', 'cool', 'values'], 'awesomeTheme');
        $collectionResult = $sut->getCollection(new ID($name), 'awesomeTheme');

        $this->assertSame(['nice', 'cool', 'values'], $collectionResult);
    }

    public function testSaveAndGetAssocCollectionSetting(): void
    {
        $name = 'coolAssocArraySetting';

        $sut = $this->getSut(
            eventDispatcher: $this->getEventDispatcherSpyForOneDispatch($name)
        );

        $this->createThemeSetting(
            theme: 'awesomeTheme',
            name: $name,
            fieldType: FieldType::ASSOCIATIVE_ARRAY,
            value: 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}'
        );

        $sut->saveAssocCollectionSetting(
            new ID($name),
            ['first' => '10', 'second' => '20', 'third' => '60'],
            'awesomeTheme'
        );
        $assocCollectionResult = $sut->getAssocCollection(new ID($name), 'awesomeTheme');

        $this->assertSame(['first' => '10', 'second' => '20', 'third' => '60'], $assocCollectionResult);
    }

    public function testGetSettingsList(): void
    {
        $themeId = 'someTheme';

        $this->createThemeSetting(theme: $themeId, name: 'one', fieldType: FieldType::NUMBER, value: 123);
        $this->createThemeSetting(theme: 'otherTheme', name: 'two', fieldType: FieldType::NUMBER, value: 231);
        $this->createThemeSetting(theme: $themeId, name: 'three', fieldType: FieldType::NUMBER, value: 3.21);

        $sut = $this->getSut();

        $this->assertSame(
            [
                'one' => 'num',
                'three' => 'num',
            ],
            $sut->getSettingsList($themeId)
        );
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
        string $theme,
        string $name,
        string $fieldType,
        mixed $value
    ): void {
        /** @var QueryBuilderFactoryInterface $queryBuilderFactory */
        $queryBuilderFactory = $this->get(QueryBuilderFactoryInterface::class);

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
                'oxmodule' => 'theme:' . $theme,
                'oxvarname' => $name,
                'oxvartype' => $fieldType,
                'oxvarvalue' => $value
            ]);
        $queryBuilder->execute();
    }

    private function getEventDispatcherSpyForOneDispatch(string $name): EventDispatcherInterface
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
