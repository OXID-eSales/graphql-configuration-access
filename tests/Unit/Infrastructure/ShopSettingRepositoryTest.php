<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TheCodingMachine\GraphQLite\Types\ID;

class ShopSettingRepositoryTest extends UnitTestCase
{
    public function testGetShopSettingInteger(): void
    {
        $nameID = new ID('integerSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('123');

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $integer = $repository->getInteger($nameID);

        $this->assertEquals(123, $integer);
    }

    public function testGetNoShopSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID);
    }

    public function testGetShopSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID);
    }

    public function testGetShopSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $float = $repository->getFloat($nameID);

        $this->assertEquals(1.23, $float);
    }

    public function testGetNoShopSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID);
    }

    public function testGetShopSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('123');

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID);
    }

    public function testGetShopSettingBooleanNegativ(): void
    {
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('');

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $boolean = $repository->getBoolean($nameID);

        $this->assertEquals(False, $boolean);
    }

    public function testGetShopSettingBooleanPositiv(): void
    {
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1');

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $boolean = $repository->getBoolean($nameID);

        $this->assertEquals(true, $boolean);
    }

    public function testGetNoShopSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID);
    }

    /**
     * @param string|bool $returnedValue
     * @return QueryBuilderFactoryInterface|MockObject
     */
    public function getQueryBuilderFactoryMock(string|bool $returnedValue): QueryBuilderFactoryInterface|MockObject
    {
        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchOne')
            ->willReturn($returnedValue);
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
}
