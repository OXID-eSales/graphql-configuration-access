<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForThemeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository
 */
class ThemeSettingRepositorySettersTest extends UnitTestCase
{
    /**
     * @dataProvider notExistingSettingCheckTriggerDataProvider
     */
    public function testSetterThrowsExceptionOnNotExistingSetting(
        string $checkMethod,
        string $repositoryMethod,
        mixed $value,
    ): void {
        $nameID = new ID('notExistingSetting');
        $themeId = 'awesomeTheme';

        $repository = $this->getSut(methods: ['getInteger']);
        $repository->method('getInteger')
            ->with($nameID, $themeId)
            ->willThrowException(new NoSettingsFoundForThemeException($themeId));

        $this->expectException(NoSettingsFoundForThemeException::class);

        $repository->saveIntegerSetting($nameID, 123, $themeId);
    }

    public function notExistingSettingCheckTriggerDataProvider(): \Generator
    {
        yield "saveIntegerSetting" => [
            'checkMethod' => 'getInteger',
            'repositoryMethod' => 'saveIntegerSetting',
            'value' => 1234
        ];
        yield "saveFloatSetting" => [
            'checkMethod' => 'getFloat',
            'repositoryMethod' => 'saveFloatSetting',
            'value' => 1_23
        ];
        yield "saveBooleanSetting" => [
            'checkMethod' => 'getBoolean',
            'repositoryMethod' => 'saveBooleanSetting',
            'value' => true
        ];
        yield "saveStringSetting" => [
            'checkMethod' => 'getString',
            'repositoryMethod' => 'saveStringSetting',
            'value' => 'some string'
        ];
        yield "saveSelectSetting" => [
            'checkMethod' => 'getSelect',
            'repositoryMethod' => 'saveSelectSetting',
            'value' => 'some select'
        ];
        yield "saveCollectionSetting" => [
            'checkMethod' => 'getCollection',
            'repositoryMethod' => 'saveCollectionSetting',
            'value' => ['collection']
        ];
        yield "saveAssocCollectionSetting" => [
            'checkMethod' => 'getAssocCollection',
            'repositoryMethod' => 'saveAssocCollectionSetting',
            'value' => ['collection']
        ];
    }

    public function getSut(
        ?array $methods = null,
        ?BasicContextInterface $basicContext = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $settingEncoder = null
    ): MockObject|ThemeSettingRepository {
        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $basicContext ?? $this->createMock(BasicContextInterface::class),
                $eventDispatcher ?? $this->createMock(EventDispatcherInterface::class),
                $queryBuilderFactory ?? $this->createMock(QueryBuilderFactoryInterface::class),
                $settingEncoder ?? $this->createMock(ShopSettingEncoderInterface::class)
            ])
            ->onlyMethods($methods ?? ['saveSettingValue'])
            ->getMock();
        return $repository;
    }
}
