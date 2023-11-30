<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoder;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository
 */
class ThemeSettingRepositoryGettersTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $nameID = new ID('integerSetting');
        $fieldType = FieldType::NUMBER;
        $value = '123';

        $settingEncoder = $this->getShopSettingEncoderMock($fieldType, $value, $value);
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn($value);

        $integer = $repository->getInteger($nameID, 'awesomeTheme');
        $this->assertEquals(123, $integer);
    }

    public function testGetThemeSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::NUMBER, 'awesomeTheme')
            ->willReturn('1.23');

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried configuration was found as a float, not an integer');
        $repository->getInteger($nameID, 'awesomeTheme');
    }

    public function testGetThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');
        $fieldType = FieldType::NUMBER;
        $value = '1.23';

        $settingEncoder = $this->getShopSettingEncoderMock($fieldType, $value, $value);
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn($value);

        $float = $repository->getFloat($nameID, 'awesomeTheme');
        $this->assertEquals(1.23, $float);
    }

    public function testGetThemeSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::NUMBER, 'awesomeTheme')
            ->willReturn('123');

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried configuration was found as an integer, not a float');
        $repository->getFloat($nameID, 'awesomeTheme');
    }

    public function testGetThemeSettingBooleanNegative(): void
    {
        $nameID = new ID('booleanSetting');
        $fieldType = FieldType::BOOLEAN;
        $encodedValue = '';
        $decodedValue = false;

        $settingEncoder = $this->getShopSettingEncoderMock($fieldType, $encodedValue, $decodedValue);
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::BOOLEAN, 'awesomeTheme')
            ->willReturn($encodedValue);

        $boolean = $repository->getBoolean($nameID, 'awesomeTheme');
        $this->assertEquals($decodedValue, $boolean);
    }

    public function testGetThemeSettingBooleanPositive(): void
    {
        $nameID = new ID('booleanSetting');
        $fieldType = FieldType::BOOLEAN;
        $encodedValue = '1';
        $decodedValue = true;

        $settingEncoder = $this->getShopSettingEncoderMock($fieldType, $encodedValue, $decodedValue);
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn($encodedValue);

        $boolean = $repository->getBoolean($nameID, 'awesomeTheme');
        $this->assertEquals($decodedValue, $boolean);
    }

    public function testGetThemeSettingString(): void
    {
        $nameID = new ID('stringSetting');
        $fieldType = FieldType::STRING;
        $value = 'default';

        $settingEncoder = $this->getShopSettingEncoderMock($fieldType, $value, $value);
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn($value);

        $string = $repository->getString($nameID, 'awesomeTheme');
        $this->assertEquals($value, $string);
    }

    public function testGetThemeSettingSelect(): void
    {
        $nameID = new ID('selectSetting');
        $fieldType = FieldType::SELECT;

        $settingEncoder = $this->getShopSettingEncoderMock($fieldType, 'select', 'select');
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn('select');

        $select = $repository->getSelect($nameID, 'awesomeTheme');
        $this->assertEquals('select', $select);
    }

    public function testGetThemeSettingCollection(): void
    {
        $nameID = new ID('arraySetting');
        $fieldType = FieldType::ARRAY;
        $encodedArray = 'a:2:{i:0;s:4:"nice";i:1;s:6:"values";}';
        $decodedArray = ['nice', 'values'];

        $settingEncoder = $this->getShopSettingEncoderMock(
            $fieldType,
            $encodedArray,
            $decodedArray
        );
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn($encodedArray);

        $collection = $repository->getCollection($nameID, 'awesomeTheme');
        $this->assertEquals($decodedArray, $collection);
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');
        $fieldType = FieldType::ASSOCIATIVE_ARRAY;
        $encodedArray = 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}';
        $decodedArray = ['first' => '10', 'second' => '20', 'third' => '50'];

        $settingEncoder = $this->getShopSettingEncoderMock(
            $fieldType,
            $encodedArray,
            $decodedArray
        );
        $repository = $this->getSut(shopSettingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willReturn($encodedArray);

        $assocCollection = $repository->getAssocCollection($nameID, 'awesomeTheme');
        $this->assertEquals($decodedArray, $assocCollection);
    }

    /**
     * @dataProvider noSettingExceptionDataProvider
     */
    public function testGetNoThemeSetting(string $repositoryMethod, string $fieldType): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, $fieldType, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);

        $repository->$repositoryMethod($nameID, 'awesomeTheme');
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
        $settingTypes = [
            'intSetting' => FieldType::NUMBER,
            'stringSetting' => FieldType::STRING,
            'arraySetting' => FieldType::ARRAY
        ];

        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchAllKeyValue')
            ->willReturn($settingTypes);
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock($result);
        $repository = $this->getThemeSettingRepository($queryBuilderFactory);

        $repositorySettingTypes = $repository->getSettingsList('awesomeTheme');
        $this->assertCount(3, $repositorySettingTypes);
        $this->assertSame($settingTypes, $repositorySettingTypes);
    }

    public function testGetNoSettingsList(): void
    {
        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchAllKeyValue')
            ->willReturn([]);
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock($result);
        $repository = $this->getThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('No configurations found for theme: "awesomeTheme"');
        $repository->getSettingsList('awesomeTheme');
    }

    /**
     * @param Result|MockObject|(Result&MockObject) $result
     * @return QueryBuilderFactoryInterface|(QueryBuilderFactoryInterface&MockObject)|MockObject
     */
    private function getQueryBuilderFactoryMock(Result|MockObject $result): QueryBuilderFactoryInterface|MockObject
    {
        $queryBuilder = $this->createPartialMock(QueryBuilder::class, ['execute']);
        $queryBuilder->expects($this->once())
            ->method('execute')
            ->willReturn($result);
        $queryBuilderFactory = $this->createMock(QueryBuilderFactoryInterface::class);
        $queryBuilderFactory->expects($this->once())
            ->method('create')
            ->willReturn($queryBuilder);
        return $queryBuilderFactory;
    }

    /**
     * @param MockObject|QueryBuilderFactoryInterface $queryBuilderFactory
     * @return ThemeSettingRepository
     */
    private function getThemeSettingRepository(
        MockObject|QueryBuilderFactoryInterface $queryBuilderFactory,
    ): ThemeSettingRepository {
        $basicContext = $this->getBasicContextMock();
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $shopSettingEncoder = new ShopSettingEncoder();
        return new ThemeSettingRepository($basicContext, $eventDispatcher, $queryBuilderFactory, $shopSettingEncoder);
    }

    private function getShopSettingEncoderMock(
        string $fieldType,
        string $value,
        mixed $returnValue
    ): ShopSettingEncoderInterface|MockObject {
        $settingEncoder = $this->createMock(ShopSettingEncoderInterface::class);
        $settingEncoder->expects($this->once())
            ->method('decode')
            ->with($fieldType, $value)
            ->willReturn($returnValue);
        return $settingEncoder;
    }

    private function getSut(
        ?BasicContextInterface $basicContext = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $shopSettingEncoder = null
    ): ThemeSettingRepository|MockObject {
        return $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $basicContext ?? $this->createStub(BasicContextInterface::class),
                $eventDispatcher ?? $this->createStub(EventDispatcherInterface::class),
                $queryBuilderFactory ?? $this->createStub(QueryBuilderFactoryInterface::class),
                $shopSettingEncoder ?? $this->createStub(ShopSettingEncoderInterface::class)
            ])
            ->onlyMethods(['getSettingValue'])
            ->getMock();
    }
}
