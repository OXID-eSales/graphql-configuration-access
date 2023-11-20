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

    public function testGetNoThemeSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getSut();
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

    public function testGetNoThemeSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::NUMBER, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloat($nameID, 'awesomeTheme');
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

    public function testGetNoThemeSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::BOOLEAN, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBoolean($nameID, 'awesomeTheme');
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

    public function testGetNoThemeSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::STRING, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getString($nameID, 'awesomeTheme');
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

    public function testGetNoThemeSettingSelect(): void
    {
        $nameID = new ID('NotExistingSetting');

        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::SELECT, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a select configuration');
        $repository->getSelect($nameID, 'awesomeTheme');
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

    public function testGetNoThemeSettingCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::ARRAY, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a collection configuration');
        $repository->getCollection($nameID, 'awesomeTheme');
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

    public function testGetNoThemeSettingAssocCollection(): void
    {
        $nameID = new ID('NotExistingSetting');
        $repository = $this->getSut();
        $repository->expects($this->once())
            ->method('getSettingValue')
            ->with($nameID, FieldType::ASSOCIATIVE_ARRAY, 'awesomeTheme')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an associative collection configuration');
        $repository->getAssocCollection($nameID, 'awesomeTheme');
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
