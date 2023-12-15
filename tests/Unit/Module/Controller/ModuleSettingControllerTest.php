<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSettingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Controller\ModuleSettingController
 */
class ModuleSettingControllerTest extends TestCase
{
    /** @dataProvider proxyTestDataProvider */
    public function testControllerProxiesParametersToServiceAndReturnsItsResult(
        string $controllerMethod,
        string $serviceMethod,
        array $params,
        $expectedValue
    ): void {
        $settingService = $this->createMock(ModuleSettingServiceInterface::class);
        $settingService->expects($this->once())->method($serviceMethod)->with(...$params)->willReturn($expectedValue);

        $settingController = new ModuleSettingController($settingService);

        $this->assertSame($expectedValue, $settingController->$controllerMethod(...$params));
    }

    public function proxyTestDataProvider(): \Generator
    {
        $settingName = 'settingName';

        yield 'getter integer' => [
            'controllerMethod' => 'moduleSettingInteger',
            'serviceMethod' => 'getIntegerSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new IntegerSetting($settingName, 123)
        ];

        yield 'getter float' => [
            'controllerMethod' => 'moduleSettingFloat',
            'serviceMethod' => 'getFloatSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new FloatSetting($settingName, 1.23)
        ];

        yield 'getter bool' => [
            'controllerMethod' => 'moduleSettingBoolean',
            'serviceMethod' => 'getBooleanSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new BooleanSetting($settingName, false)
        ];

        yield 'getter string' => [
            'controllerMethod' => 'moduleSettingString',
            'serviceMethod' => 'getStringSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new StringSetting($settingName, 'default')
        ];

        yield 'getter collection' => [
            'controllerMethod' => 'moduleSettingCollection',
            'serviceMethod' => 'getCollectionSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new StringSetting($settingName, 'someCollectionStringExample')
        ];

        yield 'setter integer' => [
            'controllerMethod' => 'moduleSettingIntegerChange',
            'serviceMethod' => 'changeIntegerSetting',
            'params' => [$settingName, 123, 'awesomeModule'],
            'expectedValue' => new IntegerSetting($settingName, 123)
        ];

        yield 'setter float' => [
            'controllerMethod' => 'moduleSettingFloatChange',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingName, 1.23, 'awesomeModule'],
            'expectedValue' => new FloatSetting($settingName, 1.23)
        ];

        yield 'setter float with integer value' => [
            'controllerMethod' => 'moduleSettingFloatChange',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingName, 123, 'awesomeModule'],
            'expectedValue' => new FloatSetting($settingName, 123)
        ];

        yield 'setter boolean' => [
            'controllerMethod' => 'moduleSettingBooleanChange',
            'serviceMethod' => 'changeBooleanSetting',
            'params' => [$settingName, false, 'awesomeModule'],
            'expectedValue' => new BooleanSetting($settingName, false)
        ];

        yield 'setter string' => [
            'controllerMethod' => 'moduleSettingStringChange',
            'serviceMethod' => 'changeStringSetting',
            'params' => [$settingName, 'some string', 'awesomeModule'],
            'expectedValue' => new StringSetting($settingName, 'some string')
        ];

        yield 'setter collection' => [
            'controllerMethod' => 'moduleSettingCollectionChange',
            'serviceMethod' => 'changeCollectionSetting',
            'params' => [$settingName, 'some collection string', 'awesomeModule'],
            'expectedValue' => new StringSetting($settingName, 'some collection string')
        ];

        yield 'list query' => [
            'controllerMethod' => 'moduleSettings',
            'serviceMethod' => 'getSettingsList',
            'params' => ['awesomeModule'],
            'expectedValue' => [
                new SettingType($settingName, FieldType::NUMBER),
                new SettingType($settingName, FieldType::NUMBER),
            ]
        ];
    }
}
