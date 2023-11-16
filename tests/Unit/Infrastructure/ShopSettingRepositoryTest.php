<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoder;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingTypeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingValueException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

class ShopSettingRepositoryTest extends UnitTestCase
{
    /** @dataProvider possibleGetterValuesDataProvider */
    public function testGetShopSetting($method, $type, $possibleValue, $expectedResult): void
    {
        $settingName = 'settingName';
        $shopId = 3;

        $shopSettingDaoStub = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')
            ->with($settingName, $shopId)
            ->willReturn(
                $this->createConfiguredMock(ShopConfigurationSetting::class, [
                    'getName' => $settingName,
                    'getType' => $type,
                    'getValue' => $possibleValue
                ])
            );

        $basicContext = $this->createStub(BasicContextInterface::class);
        $basicContext->method('getCurrentShopId')->willReturn($shopId);

        $sut = $this->getSut(
            basicContext: $basicContext,
            shopSettingDao: $shopSettingDaoStub
        );

        $this->assertSame($expectedResult, $sut->$method($settingName));
    }

    public function possibleGetterValuesDataProvider(): \Generator
    {
        yield 'int regular' => [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'possibleValue' => 123,
            'expectedResult' => 123
        ];
        yield 'int in string' => [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'possibleValue' => '123',
            'expectedResult' => 123
        ];

        yield 'float regular' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => 123.2,
            'expectedResult' => 123.2
        ];
        yield 'float from integer' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => 123,
            'expectedResult' => 123.0
        ];
        yield 'float from string' => [
            'method' => 'getFloat',
            'type' => FieldType::NUMBER,
            'possibleValue' => '123',
            'expectedResult' => 123.0
        ];

        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => 1,
            'expectedResult' => true
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => '1',
            'expectedResult' => true
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => true,
            'expectedResult' => true
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => 'anything',
            'expectedResult' => true
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => null,
            'expectedResult' => false
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => 0,
            'expectedResult' => false
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => '0',
            'expectedResult' => false
        ];
        yield [
            'method' => 'getBoolean',
            'type' => FieldType::BOOLEAN,
            'possibleValue' => false,
            'expectedResult' => false
        ];

        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => 1,
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => '1',
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => 'regular',
            'expectedResult' => 'regular'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => '0',
            'expectedResult' => '0'
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => null,
            'expectedResult' => ''
        ];
        yield [
            'method' => 'getString',
            'type' => FieldType::STRING,
            'possibleValue' => '',
            'expectedResult' => ''
        ];

        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => 1,
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => '1',
            'expectedResult' => '1'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => 'regular',
            'expectedResult' => 'regular'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => '0',
            'expectedResult' => '0'
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => null,
            'expectedResult' => ''
        ];
        yield [
            'method' => 'getSelect',
            'type' => FieldType::SELECT,
            'possibleValue' => '',
            'expectedResult' => ''
        ];
    }

    /** @dataProvider wrongSettingsDataProvider */
    public function testGetShopSettingWrongData(
        string $method,
        string $type,
        $value,
        string $expectedException
    ): void {
        $shopSettingDaoStub = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')->willReturn(
            $this->createConfiguredMock(ShopConfigurationSetting::class, [
                'getType' => $type,
                'getValue' => $value
            ])
        );

        $sut = $this->getSut(
            shopSettingDao: $shopSettingDaoStub
        );

        $this->expectException($expectedException);
        $sut->$method('settingName');
    }

    public function wrongSettingsDataProvider(): \Generator
    {
        yield [
            'method' => 'getInteger',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => 'num',
            'value' => 'any',
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => 'num',
            'value' => null,
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => 'num',
            'value' => 1.123,
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => 'num',
            'value' => '1.123',
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getFloat',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getFloat',
            'type' => 'num',
            'value' => 'any',
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getBoolean',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getString',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield [
            'method' => 'getSelect',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];
    }

    public function testGetShopSettingCollection(): void
    {
        $nameID = new ID('arraySetting');


        $repository = $this->getFetchOneShopSettingRepoInstance('a:2:{i:0;s:4:"nice";i:1;s:6:"values";}', 1);

        $collection = $repository->getCollection($nameID);

        $this->assertEquals(['nice', 'values'], $collection);
    }

    public function testGetNoShopSettingCollection(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getFetchOneShopSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a collection configuration');
        $repository->getCollection($nameID);
    }

    public function testGetShopSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');

        $serializeArrayString = 'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}';

        $repository = $this->getFetchOneShopSettingRepoInstance($serializeArrayString);

        $assocCollection = $repository->getAssocCollection($nameID);

        $this->assertEquals(['first' => '10', 'second' => '20', 'third' => '50'], $assocCollection);
    }

    public function testGetNoShopSettingAssocCollection(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getFetchOneShopSettingRepoInstance(false);

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
     * @param Result|MockObject|(Result&MockObject) $result
     * @return QueryBuilderFactoryInterface|(QueryBuilderFactoryInterface&MockObject)|MockObject
     */
    public function getQueryBuilderFactoryMock(Result|MockObject $result): QueryBuilderFactoryInterface|MockObject
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

    private function getFetchOneShopSettingRepoInstance(string|bool $qbReturnValue): ShopSettingRepositoryInterface
    {
        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchOne')
            ->willReturn($qbReturnValue);
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock($result);

        return $this->getShopSettingRepository(
            $queryBuilderFactory
        );
    }

    private function getShopSettingRepository(
        QueryBuilderFactoryInterface $queryBuilderFactory
    ): ShopSettingRepository {
        $basicContextMock = $this->getBasicContextMock(1);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $shopSettingEncoder = new ShopSettingEncoder();
        return new ShopSettingRepository(
            $basicContextMock,
            $eventDispatcher,
            $queryBuilderFactory,
            $shopSettingEncoder,
            $this->createStub(ShopConfigurationSettingDaoInterface::class)
        );
    }

    private function getSut(
        ?BasicContextInterface $basicContext = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $shopSettingEncoder = null,
        ?ShopConfigurationSettingDaoInterface $shopSettingDao = null,
    ): ShopSettingRepositoryInterface {
        return new ShopSettingRepository(
            basicContext: $basicContext ?? $this->createStub(BasicContextInterface::class),
            eventDispatcher: $eventDispatcher ?? $this->createStub(EventDispatcherInterface::class),
            queryBuilderFactory: $queryBuilderFactory ?? $this->createStub(QueryBuilderFactoryInterface::class),
            shopSettingEncoder: $shopSettingEncoder ?? $this->createStub(ShopSettingEncoderInterface::class),
            configurationSettingDao: $shopSettingDao ?? $this->createStub(ShopConfigurationSettingDaoInterface::class),
        );
    }
}
