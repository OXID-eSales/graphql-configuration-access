<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ThemeSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingServiceInterface;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ThemeSettingController
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
        $settingNameID = new ID('settingName');

        yield 'getter integer' => [
            'controllerMethod' => 'getThemeSettingInteger',
            'serviceMethod' => 'getIntegerSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new IntegerSetting($settingNameID, 123)
        ];

        yield 'getter float' => [
            'controllerMethod' => 'getThemeSettingFloat',
            'serviceMethod' => 'getFloatSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new FloatSetting($settingNameID, 1.23)
        ];

        yield 'getter bool' => [
            'controllerMethod' => 'getThemeSettingBoolean',
            'serviceMethod' => 'getBooleanSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new BooleanSetting($settingNameID, false)
        ];

        yield 'getter string' => [
            'controllerMethod' => 'getThemeSettingString',
            'serviceMethod' => 'getStringSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'default')
        ];

        yield 'getter select' => [
            'controllerMethod' => 'getThemeSettingSelect',
            'serviceMethod' => 'getSelectSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'some select setting value')
        ];

        yield 'getter collection' => [
            'controllerMethod' => 'getThemeSettingCollection',
            'serviceMethod' => 'getCollectionSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'someCollectionStringExample')
        ];

        yield 'getter associative collection' => [
            'controllerMethod' => 'getThemeSettingAssocCollection',
            'serviceMethod' => 'getAssocCollectionSetting',
            'params' => [$settingNameID, 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'some associative collection string example')
        ];

        yield 'setter integer' => [
            'controllerMethod' => 'changeThemeSettingInteger',
            'serviceMethod' => 'changeIntegerSetting',
            'params' => [$settingNameID, 123, 'awesomeTheme'],
            'expectedValue' => new IntegerSetting($settingNameID, 123)
        ];

        yield 'setter float' => [
            'controllerMethod' => 'changeThemeSettingFloat',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingNameID, 1.23, 'awesomeTheme'],
            'expectedValue' => new FloatSetting($settingNameID, 1.23)
        ];

        yield 'setter float with integer value' => [
            'controllerMethod' => 'changeThemeSettingFloat',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingNameID, 123, 'awesomeTheme'],
            'expectedValue' => new FloatSetting($settingNameID, 123)
        ];

        yield 'setter boolean' => [
            'controllerMethod' => 'changeThemeSettingBoolean',
            'serviceMethod' => 'changeBooleanSetting',
            'params' => [$settingNameID, false, 'awesomeTheme'],
            'expectedValue' => new BooleanSetting($settingNameID, false)
        ];

        yield 'setter string' => [
            'controllerMethod' => 'changeThemeSettingString',
            'serviceMethod' => 'changeStringSetting',
            'params' => [$settingNameID, 'some string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'some string')
        ];

        yield 'setter select' => [
            'controllerMethod' => 'changeThemeSettingSelect',
            'serviceMethod' => 'changeSelectSetting',
            'params' => [$settingNameID, 'some string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'some string')
        ];

        yield 'setter collection' => [
            'controllerMethod' => 'changeThemeSettingCollection',
            'serviceMethod' => 'changeCollectionSetting',
            'params' => [$settingNameID, 'some collection string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'some collection string')
        ];

        yield 'setter assoc collection' => [
            'controllerMethod' => 'changeThemeSettingAssocCollection',
            'serviceMethod' => 'changeAssocCollectionSetting',
            'params' => [$settingNameID, 'some assoc collection string', 'awesomeTheme'],
            'expectedValue' => new StringSetting($settingNameID, 'some assoc collection string')
        ];

        yield 'list query' => [
            'controllerMethod' => 'getThemeSettingsList',
            'serviceMethod' => 'getSettingsList',
            'params' => ['awesomeTheme'],
            'expectedValue' => [
                new SettingType($settingNameID, FieldType::NUMBER),
                new SettingType($settingNameID, FieldType::NUMBER),
            ]
        ];
    }
}
