<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ModuleSettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ModuleSettingServiceInterface;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\ModuleSettingController
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
        $settingNameID = new ID($settingName);

        yield 'getter integer' => [
            'controllerMethod' => 'getModuleSettingInteger',
            'serviceMethod' => 'getIntegerSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new IntegerSetting($settingNameID, 123)
        ];

        yield 'getter float' => [
            'controllerMethod' => 'getModuleSettingFloat',
            'serviceMethod' => 'getFloatSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new FloatSetting($settingNameID, 1.23)
        ];

        yield 'getter bool' => [
            'controllerMethod' => 'getModuleSettingBoolean',
            'serviceMethod' => 'getBooleanSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new BooleanSetting($settingNameID, false)
        ];

        yield 'getter string' => [
            'controllerMethod' => 'getModuleSettingString',
            'serviceMethod' => 'getStringSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new StringSetting($settingNameID, 'default')
        ];

        yield 'getter collection' => [
            'controllerMethod' => 'getModuleSettingCollection',
            'serviceMethod' => 'getCollectionSetting',
            'params' => [$settingName, 'awesomeModule'],
            'expectedValue' => new StringSetting($settingNameID, 'someCollectionStringExample')
        ];

        yield 'setter integer' => [
            'controllerMethod' => 'changeModuleSettingInteger',
            'serviceMethod' => 'changeIntegerSetting',
            'params' => [$settingName, 123, 'awesomeModule'],
            'expectedValue' => new IntegerSetting($settingNameID, 123)
        ];

        yield 'setter float' => [
            'controllerMethod' => 'changeModuleSettingFloat',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingName, 1.23, 'awesomeModule'],
            'expectedValue' => new FloatSetting($settingNameID, 1.23)
        ];

        yield 'setter float with integer value' => [
            'controllerMethod' => 'changeModuleSettingFloat',
            'serviceMethod' => 'changeFloatSetting',
            'params' => [$settingName, 123, 'awesomeModule'],
            'expectedValue' => new FloatSetting($settingNameID, 123)
        ];

        yield 'setter boolean' => [
            'controllerMethod' => 'changeModuleSettingBoolean',
            'serviceMethod' => 'changeBooleanSetting',
            'params' => [$settingName, false, 'awesomeModule'],
            'expectedValue' => new BooleanSetting($settingNameID, false)
        ];

        yield 'setter string' => [
            'controllerMethod' => 'changeModuleSettingString',
            'serviceMethod' => 'changeStringSetting',
            'params' => [$settingName, 'some string', 'awesomeModule'],
            'expectedValue' => new StringSetting($settingNameID, 'some string')
        ];

        yield 'setter collection' => [
            'controllerMethod' => 'changeModuleSettingCollection',
            'serviceMethod' => 'changeCollectionSetting',
            'params' => [$settingName, 'some collection string', 'awesomeModule'],
            'expectedValue' => new StringSetting($settingNameID, 'some collection string')
        ];

        yield 'list query' => [
            'controllerMethod' => 'getModuleSettingsList',
            'serviceMethod' => 'getSettingsList',
            'params' => ['awesomeModule'],
            'expectedValue' => [
                new SettingType($settingNameID, FieldType::NUMBER),
                new SettingType($settingNameID, FieldType::NUMBER),
            ]
        ];
    }
}
