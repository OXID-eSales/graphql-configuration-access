<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingRepositoryTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $nameID = new ID('integerSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('123');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $integer = $repository->getInteger($nameID, 'awesomeModule');

        $this->assertEquals(123, $integer);
    }

    public function testGetNoThemeSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID, 'awesomeModule');
    }
    public function testGetThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $float = $repository->getFloat($nameID, 'awesomeModule');

        $this->assertEquals(1.23, $float);
    }

    public function testGetNoThemeSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('123');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingBooleanNegative(): void
    {
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $boolean = $repository->getBoolean($nameID, 'awesomeModule');

        $this->assertEquals(False, $boolean);
    }

    public function testGetThemeSettingBooleanPositive(): void
    {
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $boolean = $repository->getBoolean($nameID, 'awesomeModule');

        $this->assertEquals(true, $boolean);
    }

    public function testGetNoThemeSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingString(): void
    {
        $nameID = new ID('stringSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('default');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $string = $repository->getString($nameID, 'awesomeModule');

        $this->assertEquals('default', $string);
    }

    public function testGetNoThemeSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getString($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingSelect(): void
    {
        $nameID = new ID('selectSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('select');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $select = $repository->getSelect($nameID, 'awesomeModule');

        $this->assertEquals('select', $select);
    }

    public function testGetNoThemeSettingSelect(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a select configuration');
        $repository->getSelect($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingCollection(): void
    {
        $nameID = new ID('arraySetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('a:2:{i:0;s:4:"nice";i:1;s:6:"values";}');
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $collection = $repository->getCollection($nameID, 'awesomeModule');

        $this->assertEquals(['nice', 'values'], $collection);
    }

    public function testGetNoThemeSettingCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a collection configuration');
        $repository->getCollection($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');

        $serializeArrayString = 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}';
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock($serializeArrayString);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $assocCollection = $repository->getAssocCollection($nameID, 'awesomeModule');

        $this->assertEquals(['first'=>'10','second'=>'20','third'=>'50'], $assocCollection);
    }

    public function testGetNoThemeSettingAssocCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);
        $basicContext = $this->getBasicContextMock();

        $repository = new ThemeSettingRepository($queryBuilderFactory, $basicContext);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an associative collection configuration');
        $repository->getAssocCollection($nameID, 'awesomeModule');
    }

    private function getBasicContextMock(int $shopId = 1): BasicContextInterface|MockObject
    {
        $basicContext = $this->createMock(BasicContextInterface::class);
        $basicContext->expects($this->any())
            ->method('getCurrentShopId')
            ->willReturn($shopId);

        return $basicContext;
    }

    /**
     * @param string|bool $returnedValue
     * @return QueryBuilderFactoryInterface|MockObject
     */
    private function getQueryBuilderFactoryMock(string|bool $returnedValue): QueryBuilderFactoryInterface|MockObject
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
