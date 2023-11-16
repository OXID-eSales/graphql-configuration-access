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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingTypeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

class ShopSettingRepositoryTest extends UnitTestCase
{
    public function testGetShopSettingInteger(): void
    {
        $settingName = 'settingName';
        $shopId = 3;

        $shopSettingValue = 123;
        $shopSettingType = 'num';

        $expectedValue = 123;

        $shopSettingDaoStub = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')
            ->with($settingName, $shopId)
            ->willReturn(
                $this->createConfiguredMock(ShopConfigurationSetting::class, [
                    'getName' => $settingName,
                    'getType' => $shopSettingType,
                    'getValue' => $shopSettingValue
                ])
            );

        $basicContext = $this->createStub(BasicContextInterface::class);
        $basicContext->method('getCurrentShopId')->willReturn($shopId);

        $sut = $this->getSut(
            basicContext: $basicContext,
            shopSettingDao: $shopSettingDaoStub
        );

        $this->assertSame($expectedValue, $sut->getInteger($settingName));
    }

    public function testGetShopSettingIntegerWrongType(): void
    {
        $settingName = 'settingName';

        $shopSettingDaoStub = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')->willReturn(
            $this->createConfiguredMock(ShopConfigurationSetting::class, [
                'getType' => 'wrong'
            ])
        );

        $sut = $this->getSut(
            shopSettingDao: $shopSettingDaoStub
        );

        $this->expectException(WrongSettingTypeException::class);
        $sut->getInteger($settingName);
    }

    public function testGetShopSettingFloat(): void
    {
        $settingName = 'settingName';
        $shopId = 3;

        $shopSettingValue = 1.23;
        $shopSettingType = 'num';

        $expectedValue = 1.23;

        $shopSettingDaoStub = $this->createMock(ShopConfigurationSettingDaoInterface::class);
        $shopSettingDaoStub->method('get')
            ->with($settingName, $shopId)
            ->willReturn(
                $this->createConfiguredMock(ShopConfigurationSetting::class, [
                    'getName' => $settingName,
                    'getType' => $shopSettingType,
                    'getValue' => $shopSettingValue
                ])
            );

        $basicContext = $this->createStub(BasicContextInterface::class);
        $basicContext->method('getCurrentShopId')->willReturn($shopId);

        $sut = $this->getSut(
            basicContext: $basicContext,
            shopSettingDao: $shopSettingDaoStub
        );

        $this->assertSame($expectedValue, $sut->getFloat($settingName));
    }
//
//    public function testGetShopSettingInvalidFloat(): void
//    {
//        $nameID = new ID('intSetting');
//
//        $repository = $this->getFetchOneShopSettingRepoInstance('123');
//
//        $this->expectException(UnexpectedValueException::class);
//        $this->expectExceptionMessage('The queried configuration was found as an integer, not a float');
//        $repository->getFloat($nameID);
//    }

    public function testGetShopSettingBooleanNegativ(): void
    {
        $nameID = new ID('booleanSetting');


        $repository = $this->getFetchOneShopSettingRepoInstance('');

        $boolean = $repository->getBoolean($nameID);

        $this->assertEquals(false, $boolean);
    }

    public function testGetShopSettingBooleanPositiv(): void
    {
        $nameID = new ID('booleanSetting');


        $repository = $this->getFetchOneShopSettingRepoInstance('1');

        $boolean = $repository->getBoolean($nameID);

        $this->assertEquals(true, $boolean);
    }

    public function testGetNoShopSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getFetchOneShopSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID);
    }

    public function testGetShopSettingString(): void
    {
        $nameID = new ID('stringSetting');


        $repository = $this->getFetchOneShopSettingRepoInstance('default');

        $string = $repository->getString($nameID);

        $this->assertEquals('default', $string);
    }

    public function testGetNoShopSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getFetchOneShopSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getString($nameID);
    }

    public function testGetShopSettingSelect(): void
    {
        $nameID = new ID('selectSetting');


        $repository = $this->getFetchOneShopSettingRepoInstance('select');

        $select = $repository->getSelect($nameID);

        $this->assertEquals('select', $select);
    }

    public function testGetNoShopSettingSelect(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getFetchOneShopSettingRepoInstance(false);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a select configuration');
        $repository->getSelect($nameID);
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
