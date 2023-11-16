<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ShopSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ShopSettingServiceInterface;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ShopSettingController
 */
class ShopSettingControllerTest extends TestCase
{
    /** @dataProvider proxyTestDataProvider */
    public function testControllerProxiesParametersToServiceAndReturnsItsResult(
        string $controllerMethod,
        string $serviceMethod,
        array $params,
        $expectedValue
    ): void {
        $settingService = $this->createMock(ShopSettingServiceInterface::class);
        $settingService->expects($this->once())->method($serviceMethod)->with(...$params)->willReturn($expectedValue);

        $settingController = new ShopSettingController($settingService);

        $this->assertSame($expectedValue, $settingController->$controllerMethod(...$params));
    }

    public function proxyTestDataProvider(): \Generator
    {
        $settingNameID = new ID('settingName');

        yield 'getter integer' => [
            'controllerMethod' => 'getShopSettingInteger',
            'serviceMethod' => 'getIntegerSetting',
            'params' => [$settingNameID],
            'expectedValue' => new IntegerSetting($settingNameID, 123)
        ];

        yield 'getter float' => [
            'controllerMethod' => 'getShopSettingFloat',
            'serviceMethod' => 'getFloatSetting',
            'params' => [$settingNameID],
            'expectedValue' => new FloatSetting($settingNameID, 1.23)
        ];

        yield 'getter bool' => [
            'controllerMethod' => 'getShopSettingBoolean',
            'serviceMethod' => 'getBooleanSetting',
            'params' => [$settingNameID],
            'expectedValue' => new BooleanSetting($settingNameID, false)
        ];

        yield 'getter string' => [
            'controllerMethod' => 'getShopSettingString',
            'serviceMethod' => 'getStringSetting',
            'params' => [$settingNameID],
            'expectedValue' => new StringSetting($settingNameID, 'default')
        ];

        yield 'getter select' => [
            'controllerMethod' => 'getShopSettingSelect',
            'serviceMethod' => 'getSelectSetting',
            'params' => [$settingNameID],
            'expectedValue' => new StringSetting($settingNameID, 'some select setting value')
        ];

        yield 'getter collection' => [
            'controllerMethod' => 'getShopSettingCollection',
            'serviceMethod' => 'getCollectionSetting',
            'params' => [$settingNameID],
            'expectedValue' => new StringSetting($settingNameID, 'some collection string example')
        ];

        yield 'getter associative collection' => [
            'controllerMethod' => 'getShopSettingAssocCollection',
            'serviceMethod' => 'getAssocCollectionSetting',
            'params' => [$settingNameID],
            'expectedValue' => new StringSetting($settingNameID, 'some associative collection string example')
        ];

        yield 'setting list getter' => [
            'controllerMethod' => 'getShopSettingsList',
            'serviceMethod' => 'getSettingsList',
            'params' => [],
            'expectedValue' => [
                new SettingType($settingNameID, FieldType::NUMBER),
                new SettingType($settingNameID, FieldType::NUMBER),
            ]
        ];
    }
}
