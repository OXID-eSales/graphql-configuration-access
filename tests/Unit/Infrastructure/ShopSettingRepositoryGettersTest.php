<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\DataObject\ShopConfigurationSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingTypeException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\WrongSettingValueException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository
 */
class ShopSettingRepositoryGettersTest extends AbstractShopSettingRepositoryTest
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

        $sut = $this->getSut(
            basicContext: $this->getBasicContextMock($shopId),
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

        yield 'empty string collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => '',
            'expectedResult' => []
        ];

        yield 'empty array collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => [],
            'expectedResult' => []
        ];

        yield 'filled array collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => ['one', 'two'],
            'expectedResult' => ['one', 'two']
        ];

        yield 'associative array in collection is ok' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => ['one' => 'oneValue', 'two' => 'twoValue'],
            'expectedResult' => ['one' => 'oneValue', 'two' => 'twoValue']
        ];

        yield 'empty string for assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => '',
            'expectedResult' => []
        ];

        yield 'empty array for assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => [],
            'expectedResult' => []
        ];

        yield 'filled not assoc array for assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => ['one', 'two'],
            'expectedResult' => ['one', 'two']
        ];

        yield 'associative array in assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => ['one' => 'oneValue', 'two' => 'twoValue'],
            'expectedResult' => ['one' => 'oneValue', 'two' => 'twoValue']
        ];
    }

    /** @dataProvider wrongSettingsDataProvider */
    public function testGetShopSettingWrongData(
        string $method,
        string $type,
        $value,
        string $expectedException
    ): void {
        $shopSettingDaoStub = $this->createStub(ShopConfigurationSettingDaoInterface::class);
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
            'type' => FieldType::NUMBER,
            'value' => 'any',
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'value' => null,
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
            'value' => 1.123,
            'expectedException' => WrongSettingValueException::class
        ];

        yield [
            'method' => 'getInteger',
            'type' => FieldType::NUMBER,
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
            'type' => FieldType::NUMBER,
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

        yield [
            'method' => 'getCollection',
            'type' => 'wrong',
            'value' => 'any',
            'expectedException' => WrongSettingTypeException::class
        ];

        yield 'false as the error result of unserialize' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'string instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => 'some string',
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'integer instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => 123,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'float instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => 1.23,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'null instead of collection' => [
            'method' => 'getCollection',
            'type' => FieldType::ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'false as the error result of unserialize in assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'string instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => 'some string',
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'integer instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => 123,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'float instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => 1.23,
            'expectedResult' => WrongSettingValueException::class
        ];

        yield 'null instead of assoc collection' => [
            'method' => 'getAssocCollection',
            'type' => FieldType::ASSOCIATIVE_ARRAY,
            'possibleValue' => false,
            'expectedResult' => WrongSettingValueException::class
        ];
    }
}
