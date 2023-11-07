<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingRepositoryTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $nameID = new ID('integerSetting');

        $repository = $this->getThemeSettingRepoInstance('123');

        $integer = $repository->getInteger($nameID, 'awesomeModule');

        $this->assertEquals(123, $integer);
    }

    public function testGetNoThemeSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(False);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');

        $repository = $this->getThemeSettingRepoInstance('1.23');

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getInteger($nameID, 'awesomeModule');
    }
    public function testGetThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $repository = $this->getThemeSettingRepoInstance('1.23');

        $float = $repository->getFloat($nameID, 'awesomeModule');

        $this->assertEquals(1.23, $float);
    }

    public function testGetNoThemeSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(False);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');

        $repository = $this->getThemeSettingRepoInstance('123');

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingBooleanNegative(): void
    {
        $nameID = new ID('booleanSetting');

        $repository = $this->getThemeSettingRepoInstance('');

        $boolean = $repository->getBoolean($nameID, 'awesomeModule');

        $this->assertEquals(False, $boolean);
    }

    public function testGetThemeSettingBooleanPositive(): void
    {
        $nameID = new ID('booleanSetting');

        $repository = $this->getThemeSettingRepoInstance('1');

        $boolean = $repository->getBoolean($nameID, 'awesomeModule');

        $this->assertEquals(true, $boolean);
    }

    public function testGetNoThemeSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(False);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingString(): void
    {
        $nameID = new ID('stringSetting');

        $repository = $this->getThemeSettingRepoInstance('default');

        $string = $repository->getString($nameID, 'awesomeModule');

        $this->assertEquals('default', $string);
    }

    public function testGetNoThemeSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(False);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getString($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingSelect(): void
    {
        $nameID = new ID('selectSetting');

        $repository = $this->getThemeSettingRepoInstance('select');

        $select = $repository->getSelect($nameID, 'awesomeModule');

        $this->assertEquals('select', $select);
    }

    public function testGetNoThemeSettingSelect(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(False);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a select configuration');
        $repository->getSelect($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingCollection(): void
    {
        $nameID = new ID('arraySetting');

        $repository = $this->getThemeSettingRepoInstance('a:2:{i:0;s:4:"nice";i:1;s:6:"values";}');

        $collection = $repository->getCollection($nameID, 'awesomeModule');

        $this->assertEquals(['nice', 'values'], $collection);
    }

    public function testGetNoThemeSettingCollection(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(False);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a collection configuration');
        $repository->getCollection($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');

        $serializeArrayString = 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}';

        $repository = $this->getThemeSettingRepoInstance($serializeArrayString);

        $assocCollection = $repository->getAssocCollection($nameID, 'awesomeModule');

        $this->assertEquals(['first'=>'10','second'=>'20','third'=>'50'], $assocCollection);
    }

    public function testGetNoThemeSettingAssocCollection(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an associative collection configuration');
        $repository->getAssocCollection($nameID, 'awesomeModule');
    }

    private function getBasicContextMock(int $shopId): BasicContextInterface|MockObject
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

    private function getThemeSettingRepoInstance(string|bool $qbReturnedValue, int $shopId = 1): ThemeSettingRepositoryInterface
    {
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock($qbReturnedValue);
        $shopConfigurationDao = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $shopSettingEncoder = $this->createMock(ShopSettingEncoderInterface::class);
        $basicContext = $this->getBasicContextMock($shopId);

        return new ThemeSettingRepository(
            $basicContext,
            $eventDispatcher,
            $shopConfigurationDao,
            $shopSettingEncoder,
            $queryBuilderFactory
        );
    }
}
