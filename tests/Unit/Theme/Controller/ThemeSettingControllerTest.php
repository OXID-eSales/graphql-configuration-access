<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeSettingController;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeSettingController
 */
class ThemeSettingControllerTest extends TestCase
{
    /** @dataProvider proxyTestDataProvider */
    public function testControllerProxiesParametersToServiceAndReturnsItsResult(
        string $controllerMethod,
        string $serviceMethod,
        array $params,
        $expectedValue
    ): void {
        $settingService = $this->createMock(ThemeSettingServiceInterface::class);
        $settingService->expects($this->once())->method($serviceMethod)->with(...$params)->willReturn($expectedValue);

        $settingController = new ThemeSettingController($settingService);

        $this->assertSame($expectedValue, $settingController->$controllerMethod(...$params));
    }

    public function proxyTestDataProvider(): \Generator
    {
        $name = 'settingName';

        yield 'getter integer' => [
            'controllerMethod' => 'getThemeSettingInteger',
            'serviceMethod' => 'getIntegerSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new IntegerSetting($name, 123)
        ];

        yield 'getter float' => [
            'controllerMethod' => 'getThemeSettingFloat',
            'serviceMethod' => 'getFloatSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new FloatSetting($name, 1.23)
        ];

        yield 'getter bool' => [
            'controllerMethod' => 'getThemeSettingBoolean',
            'serviceMethod' => 'getBooleanSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new BooleanSetting($name, false)
        ];

        yield 'getter string' => [
            'controllerMethod' => 'getThemeSettingString',
            'serviceMethod' => 'getStringSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'default')
        ];

        yield 'getter select' => [
            'controllerMethod' => 'getThemeSettingSelect',
            'serviceMethod' => 'getSelectSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'some select setting value')
        ];

        yield 'getter collection' => [
            'controllerMethod' => 'getThemeSettingCollection',
            'serviceMethod' => 'getCollectionSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'someCollectionStringExample')
        ];

        yield 'getter associative collection' => [
            'controllerMethod' => 'getThemeSettingAssocCollection',
            'serviceMethod' => 'getAssocCollectionSetting',
            'params' => [$name, 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'some associative collection string example')
        ];

        yield 'setter integer' => [
            'controllerMethod' => 'changeThemeSettingInteger',
            'serviceMethod' => 'changeIntegerSetting',
            'params' => [$name, 123, 'awesomeTheme'],
            'expectedValue' => new IntegerSetting($name, 123)
        ];

        yield 'setter float' => [
            'controllerMethod' => 'changeThemeSettingFloat',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$name, 1.23, 'awesomeTheme'],
            'expectedValue' => new FloatSetting($name, 1.23)
        ];

        yield 'setter float with integer value' => [
            'controllerMethod' => 'changeThemeSettingFloat',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$name, 123, 'awesomeTheme'],
            'expectedValue' => new FloatSetting($name, 123)
        ];

        yield 'setter boolean' => [
            'controllerMethod' => 'changeThemeSettingBoolean',
            'serviceMethod' => 'changeBooleanSetting',
            'params' => [$name, false, 'awesomeTheme'],
            'expectedValue' => new BooleanSetting($name, false)
        ];

        yield 'setter string' => [
            'controllerMethod' => 'changeThemeSettingString',
            'serviceMethod' => 'changeStringSetting',
            'params' => [$name, 'some string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'some string')
        ];

        yield 'setter select' => [
            'controllerMethod' => 'changeThemeSettingSelect',
            'serviceMethod' => 'changeSelectSetting',
            'params' => [$name, 'some string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'some string')
        ];

        yield 'setter collection' => [
            'controllerMethod' => 'changeThemeSettingCollection',
            'serviceMethod' => 'changeCollectionSetting',
            'params' => [$name, 'some collection string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'some collection string')
        ];

        yield 'setter assoc collection' => [
            'controllerMethod' => 'changeThemeSettingAssocCollection',
            'serviceMethod' => 'changeAssocCollectionSetting',
            'params' => [$name, 'some assoc collection string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($name, 'some assoc collection string')
        ];

        yield 'list query' => [
            'controllerMethod' => 'getThemeSettingsList',
            'serviceMethod' => 'getSettingsList',
            'params' => ['awesomeTheme'],
            'expectedValue' => [
                new SettingType($name, FieldType::NUMBER),
                new SettingType($name, FieldType::NUMBER),
            ]
        ];
    }
}
