<?php

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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

class GetThemeSettingRepositoryTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $nameID = new ID('integerSetting');
        $settingEncoder = $this->createMock(ShopSettingEncoderInterface::class);
        $settingEncoder->expects($this->once())
            ->method('decode')
            ->with(FieldType::NUMBER, '123')
            ->willReturn('123');

        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $this->createMock(BasicContextInterface::class),
                $this->createMock(EventDispatcherInterface::class),
                $this->createMock(QueryBuilderFactoryInterface::class),
                $settingEncoder
            ])
            ->onlyMethods(['getSettingValue'])
            ->getMock();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::NUMBER, 'awesomeTheme')
            ->willReturn('123');

        $integer = $repository->getInteger($nameID, 'awesomeTheme');

        $this->assertEquals(123, $integer);
    }

    public function testGetNoThemeSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $this->createMock(BasicContextInterface::class),
                $this->createMock(EventDispatcherInterface::class),
                $this->createMock(QueryBuilderFactoryInterface::class),
                $this->createMock(ShopSettingEncoderInterface::class)
            ])
            ->onlyMethods(['getSettingValue'])
            ->getMock();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::NUMBER, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');

        $repository->getInteger($nameID, 'awesomeTheme');
    }

    public function testGetThemeSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('1.23');

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried configuration was found as a float, not an integer');
        $repository->getInteger($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $repository = $this->getFetchOneThemeSettingRepoInstance('1.23');

        $float = $repository->getFloat($nameID, 'awesomeModule');

        $this->assertEquals(1.23, $float);
    }

    public function testGetNoThemeSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('123');

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried configuration was found as an integer, not a float');
        $repository->getFloat($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingBooleanNegative(): void
    {
        $nameID = new ID('booleanSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('');

        $boolean = $repository->getBoolean($nameID, 'awesomeModule');

        $this->assertEquals(false, $boolean);
    }

    public function testGetThemeSettingBooleanPositive(): void
    {
        $nameID = new ID('booleanSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('1');

        $boolean = $repository->getBoolean($nameID, 'awesomeModule');

        $this->assertEquals(true, $boolean);
    }

    public function testGetNoThemeSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingString(): void
    {
        $nameID = new ID('stringSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('default');

        $string = $repository->getString($nameID, 'awesomeModule');

        $this->assertEquals('default', $string);
    }

    public function testGetNoThemeSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getString($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingSelect(): void
    {
        $nameID = new ID('selectSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('select');

        $select = $repository->getSelect($nameID, 'awesomeModule');

        $this->assertEquals('select', $select);
    }

    public function testGetNoThemeSettingSelect(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a select configuration');
        $repository->getSelect($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingCollection(): void
    {
        $nameID = new ID('arraySetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance('a:2:{i:0;s:4:"nice";i:1;s:6:"values";}');

        $collection = $repository->getCollection($nameID, 'awesomeModule');

        $this->assertEquals(['nice', 'values'], $collection);
    }

    public function testGetNoThemeSettingCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a collection configuration');
        $repository->getCollection($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');

        $serializeArrayString = 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}';
        $repository = $this->getFetchOneThemeSettingRepoInstance($serializeArrayString);

        $assocCollection = $repository->getAssocCollection($nameID, 'awesomeModule');

        $this->assertEquals(['first' => '10', 'second' => '20', 'third' => '50'], $assocCollection);
    }

    public function testGetNoThemeSettingAssocCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getFetchOneThemeSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an associative collection configuration');
        $repository->getAssocCollection($nameID, 'awesomeModule');
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
     * @param string|bool $returnedValue
     * @return QueryBuilderFactoryInterface|(QueryBuilderFactoryInterface&MockObject)|MockObject
     */
    private function getFetchOneQueryBuilderFactoryMock(
        string|bool $returnedValue
    ): QueryBuilderFactoryInterface|MockObject {
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

    private function getFetchOneThemeSettingRepoInstance(string|bool $qbReturnedValue): ThemeSettingRepositoryInterface
    {
        $queryBuilderFactory = $this->getFetchOneQueryBuilderFactoryMock($qbReturnedValue);
        return $this->getThemeSettingRepository($queryBuilderFactory);
    }
}
