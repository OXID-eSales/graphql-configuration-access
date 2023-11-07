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
use UnexpectedValueException;

class ShopSettingRepositoryTest extends UnitTestCase
{
    public function testGetShopSettingInteger(): void
    {
        $nameID = new ID('integerSetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('123');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $integer = $repository->getInteger($nameID);

        $this->assertEquals(123, $integer);
    }

    public function testGetNoShopSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID);
    }

    public function testGetShopSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('1.23');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried configuration was found as a float, not an integer');
        $repository->getInteger($nameID);
    }

    public function testGetShopSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('1.23');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $float = $repository->getFloat($nameID);

        $this->assertEquals(1.23, $float);
    }

    public function testGetNoShopSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID);
    }

    public function testGetShopSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('123');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried configuration was found as an integer, not a float');
        $repository->getFloat($nameID);
    }

    public function testGetShopSettingBooleanNegativ(): void
    {
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $boolean = $repository->getBoolean($nameID);

        $this->assertEquals(False, $boolean);
    }

    public function testGetShopSettingBooleanPositiv(): void
    {
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('1');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $boolean = $repository->getBoolean($nameID);

        $this->assertEquals(true, $boolean);
    }

    public function testGetNoShopSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID);
    }

    public function testGetShopSettingString(): void
    {
        $nameID = new ID('stringSetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('default');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $string = $repository->getString($nameID);

        $this->assertEquals('default', $string);
    }

    public function testGetNoShopSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getString($nameID);
    }

    public function testGetShopSettingSelect(): void
    {
        $nameID = new ID('selectSetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('select');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $select = $repository->getSelect($nameID);

        $this->assertEquals('select', $select);
    }

    public function testGetNoShopSettingSelect(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a select configuration');
        $repository->getSelect($nameID);
    }

    public function testGetShopSettingCollection(): void
    {
        $nameID = new ID('arraySetting');

        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock('a:2:{i:0;s:4:"nice";i:1;s:6:"values";}');

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $collection = $repository->getCollection($nameID);

        $this->assertEquals(['nice', 'values'], $collection);
    }

    public function testGetNoShopSettingCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a collection configuration');
        $repository->getCollection($nameID);
    }

    public function testGetShopSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');

        $serializeArrayString = 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}';
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock($serializeArrayString);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $assocCollection = $repository->getAssocCollection($nameID);

        $this->assertEquals(['first'=>'10','second'=>'20','third'=>'50'], $assocCollection);
    }

    public function testGetNoShopSettingAssocCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock(False);

        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an associative collection configuration');
        $repository->getAssocCollection($nameID);
    }

    public function testGetNoSettingsList(): void
    {
        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchAllKeyValue')
            ->willReturn([]);
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock($result);
        $repository = $this->getShopSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('No configurations found for shopID: "1"');
        $repository->getSettingsList();
    }

    /**
     * @param string|bool $returnedValue
     * @return QueryBuilderFactoryInterface|(QueryBuilderFactoryInterface&MockObject)|MockObject
     */
    private function getFetchOneQueryBuilderFactoryMock(string|bool $returnedValue): QueryBuilderFactoryInterface|MockObject
    {
        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchOne')
            ->willReturn($returnedValue);
        return $this->getQueryBuilderFactoryMock($result);
    }

    /**
     * @param Result|MockObject|(Result&MockObject) $result
     * @return QueryBuilderFactoryInterface|(QueryBuilderFactoryInterface&MockObject)|MockObject
     */
    public function getQueryBuilderFactoryMock(Result|MockObject $result
    ): QueryBuilderFactoryInterface|MockObject {
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
     * @return ShopSettingRepository
     */
    private function getShopSettingRepository(MockObject|QueryBuilderFactoryInterface $queryBuilderFactory
    ): ShopSettingRepository {
        $basicContextMock = $this->getBasicContextMock();
        return new ShopSettingRepository($queryBuilderFactory, $basicContextMock);
    }
}
