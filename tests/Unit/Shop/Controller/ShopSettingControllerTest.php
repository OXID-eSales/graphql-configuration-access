<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shop\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Controller\ShopSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Shop\Service\ShopSettingServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shop\Controller\ShopSettingController
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
        $settingName = 'settingName';

        yield 'getter integer' => [
            'controllerMethod' => 'shopSettingInteger',
            'serviceMethod' => 'getIntegerSetting',
            'params' => [$settingName],
            'expectedValue' => new IntegerSetting($settingName, 123)
        ];

        yield 'getter float' => [
            'controllerMethod' => 'shopSettingFloat',
            'serviceMethod' => 'getFloatSetting',
            'params' => [$settingName],
            'expectedValue' => new FloatSetting($settingName, 1.23)
        ];

        yield 'getter bool' => [
            'controllerMethod' => 'shopSettingBoolean',
            'serviceMethod' => 'getBooleanSetting',
            'params' => [$settingName],
            'expectedValue' => new BooleanSetting($settingName, false)
        ];

        yield 'getter string' => [
            'controllerMethod' => 'shopSettingString',
            'serviceMethod' => 'getStringSetting',
            'params' => [$settingName],
            'expectedValue' => new StringSetting($settingName, 'default')
        ];

        yield 'getter select' => [
            'controllerMethod' => 'shopSettingSelect',
            'serviceMethod' => 'getSelectSetting',
            'params' => [$settingName],
            'expectedValue' => new StringSetting($settingName, 'some select setting value')
        ];

        yield 'getter collection' => [
            'controllerMethod' => 'shopSettingCollection',
            'serviceMethod' => 'getCollectionSetting',
            'params' => [$settingName],
            'expectedValue' => new StringSetting($settingName, 'some collection string example')
        ];

        yield 'getter associative collection' => [
            'controllerMethod' => 'shopSettingAssocCollection',
            'serviceMethod' => 'getAssocCollectionSetting',
            'params' => [$settingName],
            'expectedValue' => new StringSetting($settingName, 'some associative collection string example')
        ];

        yield 'setter integer' => [
            'controllerMethod' => 'shopSettingIntegerChange',
            'serviceMethod' => 'changeIntegerSetting',
            'params' => [$settingName, 123],
            'expectedValue' => new IntegerSetting($settingName, 123)
        ];

        yield 'setter float' => [
            'controllerMethod' => 'shopSettingFloatChange',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingName, 1.23],
            'expectedValue' => new FloatSetting($settingName, 1.23)
        ];

        yield 'setter float with integer value' => [
            'controllerMethod' => 'shopSettingFloatChange',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingName, 123],
            'expectedValue' => new FloatSetting($settingName, 123)
        ];

        yield 'setter boolean' => [
            'controllerMethod' => 'shopSettingBooleanChange',
            'serviceMethod' => 'changeBooleanSetting',
            'params' => [$settingName, false],
            'expectedValue' => new BooleanSetting($settingName, false)
        ];

        yield 'setter string' => [
            'controllerMethod' => 'shopSettingStringChange',
            'serviceMethod' => 'changeStringSetting',
            'params' => [$settingName, 'some string'],
            'expectedValue' => new StringSetting($settingName, 'some string')
        ];

        yield 'setter select' => [
            'controllerMethod' => 'shopSettingSelectChange',
            'serviceMethod' => 'changeSelectSetting',
            'params' => [$settingName, 'some select value'],
            'expectedValue' => new StringSetting($settingName, 'some select value')
        ];

        yield 'setter collection' => [
            'controllerMethod' => 'shopSettingCollectionChange',
            'serviceMethod' => 'changeCollectionSetting',
            'params' => [$settingName, 'some collection string'],
            'expectedValue' => new StringSetting($settingName, 'some collection string')
        ];

        yield 'setter assoc collection' => [
            'controllerMethod' => 'shopSettingAssocCollectionChange',
            'serviceMethod' => 'changeAssocCollectionSetting',
            'params' => [$settingName, 'some assoc collection string'],
            'expectedValue' => new StringSetting($settingName, 'some assoc collection string')
        ];

        yield 'setting list getter' => [
            'controllerMethod' => 'shopSettings',
            'serviceMethod' => 'getSettingsList',
            'params' => [],
            'expectedValue' => [
                new SettingType($settingName, FieldType::NUMBER),
                new SettingType($settingName, FieldType::NUMBER),
            ]
        ];
    }
}
