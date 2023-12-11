<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\NoSettingsFoundForThemeException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSettingRepository
 */
class ThemeSettingRepositorySettersTest extends AbstractThemeSettingRepositoryTestCase
{
    /**
     * @dataProvider notExistingSettingCheckTriggerDataProvider
     */
    public function testSetterThrowsExceptionOnNotExistingSetting(
        string $repositoryMethod,
        mixed $value,
    ): void {
        $name = 'notExistingSetting';
        $themeId = 'awesomeTheme';

        $sut = $this->getSut(methods: ['getSettingValue', 'saveSettingValue']);
        $sut->method('getSettingValue')
            ->with($name, $this->logicalOr(...FieldType::getEnums()), $themeId)
            ->willThrowException(new NoSettingsFoundForThemeException($themeId));
        $sut->expects($this->never())
            ->method('saveSettingValue');

        $this->expectException(NoSettingsFoundForThemeException::class);

        $sut->$repositoryMethod($name, $value, $themeId);
    }

    public function notExistingSettingCheckTriggerDataProvider(): \Generator
    {
        yield "saveIntegerSetting" => [
            'repositoryMethod' => 'saveIntegerSetting',
            'value' => 1234
        ];
        yield "saveFloatSetting" => [
            'repositoryMethod' => 'saveFloatSetting',
            'value' => 1.23
        ];
        yield "saveBooleanSetting" => [
            'repositoryMethod' => 'saveBooleanSetting',
            'value' => true
        ];
        yield "saveStringSetting" => [
            'repositoryMethod' => 'saveStringSetting',
            'value' => 'some string'
        ];
        yield "saveSelectSetting" => [
            'repositoryMethod' => 'saveSelectSetting',
            'value' => 'some select'
        ];
        yield "saveCollectionSetting" => [
            'repositoryMethod' => 'saveCollectionSetting',
            'value' => ['collection']
        ];
        yield "saveAssocCollectionSetting" => [
            'repositoryMethod' => 'saveAssocCollectionSetting',
            'value' => ['collection']
        ];
    }
}
