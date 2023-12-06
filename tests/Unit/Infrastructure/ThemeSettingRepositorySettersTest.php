<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\NoSettingsFoundForThemeException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSettingRepository
 */
class ThemeSettingRepositorySettersTest extends AbstractThemeSettingRepositoryTestCase
{
    /**
     * @dataProvider notExistingSettingCheckTriggerDataProvider
     */
    public function testSetterThrowsExceptionOnNotExistingSetting(
        string $checkMethod,
        string $repositoryMethod,
        mixed $value,
    ): void {
        $name = 'notExistingSetting';
        $themeId = 'awesomeTheme';

        $sut = $this->getSut(methods: [$checkMethod, 'saveSettingValue']);
        $sut->method($checkMethod)
            ->with($name, $themeId)
            ->willThrowException(new NoSettingsFoundForThemeException($themeId));
        $sut->expects($this->never())
            ->method('saveSettingValue');

        $this->expectException(NoSettingsFoundForThemeException::class);

        $sut->$repositoryMethod($name, $value, $themeId);
    }

    public function notExistingSettingCheckTriggerDataProvider(): \Generator
    {
        yield "saveIntegerSetting" => [
            'checkMethod' => 'getInteger',
            'repositoryMethod' => 'saveIntegerSetting',
            'value' => 1234
        ];
        yield "saveFloatSetting" => [
            'checkMethod' => 'getFloat',
            'repositoryMethod' => 'saveFloatSetting',
            'value' => 1.23
        ];
        yield "saveBooleanSetting" => [
            'checkMethod' => 'getBoolean',
            'repositoryMethod' => 'saveBooleanSetting',
            'value' => true
        ];
        yield "saveStringSetting" => [
            'checkMethod' => 'getString',
            'repositoryMethod' => 'saveStringSetting',
            'value' => 'some string'
        ];
        yield "saveSelectSetting" => [
            'checkMethod' => 'getSelect',
            'repositoryMethod' => 'saveSelectSetting',
            'value' => 'some select'
        ];
        yield "saveCollectionSetting" => [
            'checkMethod' => 'getCollection',
            'repositoryMethod' => 'saveCollectionSetting',
            'value' => ['collection']
        ];
        yield "saveAssocCollectionSetting" => [
            'checkMethod' => 'getAssocCollection',
            'repositoryMethod' => 'saveAssocCollectionSetting',
            'value' => ['collection']
        ];
    }
}
