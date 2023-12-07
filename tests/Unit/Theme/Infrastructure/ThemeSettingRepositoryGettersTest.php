<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\NoSettingsFoundForThemeException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSettingRepository
 */
class ThemeSettingRepositoryGettersTest extends AbstractThemeSettingRepositoryTestCase
{
    /**
     * @dataProvider possibleGetIntegerValuesDataProvider
     * @dataProvider possibleGetFloatValuesDataProvider
     * @dataProvider possibleGetBooleanValuesDataProvider
     * @dataProvider possibleGetStringValuesDataProvider
     * @dataProvider possibleGetSelectValuesDataProvider
     * @dataProvider possibleGetCollectionValuesDataProvider
     * @dataProvider possibleGetAssocCollectionValuesDataProvider
     */
    public function testGetThemeSetting(string $method, string $type, mixed $possibleValue, mixed $expectedResult): void
    {
        $name = uniqid();
        $sut = $this->getSut(methods: ['getSettingValue']);

        $sut->expects($this->once())
            ->method('getSettingValue')
            ->with($name, $type, 'awesomeTheme')
            ->willReturn($possibleValue);

        $this->assertEquals($expectedResult, $sut->$method($name, 'awesomeTheme'));
    }

    /**
     * @dataProvider wrongSettingsValueDataProvider
     */
    public function testGetThemeSettingWrongData(
        string $method,
        string $type,
        mixed $value,
        string $expectedException
    ): void {
        $name = uniqid();
        $sut = $this->getSut(methods: ['getSettingValue']);

        $sut->expects($this->once())
            ->method('getSettingValue')
            ->with($name, $type, 'awesomeTheme')
            ->willReturn($value);

        $this->expectException($expectedException);
        $sut->$method($name, 'awesomeTheme');
    }

    /**
     * @dataProvider noSettingExceptionDataProvider
     */
    public function testGetNoThemeSetting(string $repositoryMethod): void
    {
        $sut = $this->getSut(
            queryBuilderFactory: $this->getQueryBuilderWithFetchResult('fetchOne', false)
        );

        $this->expectException(NoSettingsFoundForThemeException::class);
        $sut->$repositoryMethod('NotExistingSetting', 'awesomeTheme');
    }

    public function noSettingExceptionDataProvider(): \Generator
    {
        yield 'getInteger' => ['repositoryMethod' => 'getInteger', 'fieldType' => FieldType::NUMBER];
        yield 'getFloat' => ['repositoryMethod' => 'getFloat', 'fieldType' => FieldType::NUMBER];
        yield 'getBoolean' => ['repositoryMethod' => 'getBoolean', 'fieldType' => FieldType::BOOLEAN];
        yield 'getString' => ['repositoryMethod' => 'getString', 'fieldType' => FieldType::STRING];
        yield 'getSelect' => ['repositoryMethod' => 'getSelect', 'fieldType' => FieldType::SELECT];
        yield 'getCollection' => ['repositoryMethod' => 'getCollection', 'fieldType' => FieldType::ARRAY];
        yield 'getAssocCollection' => [
            'repositoryMethod' => 'getAssocCollection',
            'fieldType' => FieldType::ASSOCIATIVE_ARRAY
        ];
    }

    public function testGetSettingsList(): void
    {
        $sut = $this->getSut(
            queryBuilderFactory: $this->getQueryBuilderWithFetchResult('fetchAllKeyValue', [])
        );

        $this->expectException(NoSettingsFoundForThemeException::class);
        $sut->getSettingsList('awesomeTheme');
    }

    private function getQueryBuilderWithFetchResult(
        string $fetchMethod,
        mixed $fetchResult
    ): QueryBuilderFactoryInterface {
        $queryBuilderFactoryStub = $this->createMock(QueryBuilderFactoryInterface::class);
        $queryBuilderFactoryStub->expects($this->once())
            ->method('create')
            ->willReturn(
                $queryBuilderStub = $this->createPartialMock(QueryBuilder::class, ['execute'])
            );

        $queryBuilderStub->expects($this->once())
            ->method('execute')
            ->willReturn($resultStub = $this->createMock(Result::class));

        $resultStub->expects($this->once())
            ->method($fetchMethod)
            ->willReturn($fetchResult);

        return $queryBuilderFactoryStub;
    }
}
