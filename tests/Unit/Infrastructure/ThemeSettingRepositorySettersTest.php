<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\NoSettingsFoundForThemeException;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository
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

        $repository = $this->getSut(methods: ['getSettingValue']);
        $repository->method('getSettingValue')
            ->with($name, $this->anything(), $themeId)
            ->willThrowException(new NoSettingsFoundForThemeException($themeId));

        $this->expectException(NoSettingsFoundForThemeException::class);

        $repository->$repositoryMethod($name, $value, $themeId);
    }

    public function notExistingSettingCheckTriggerDataProvider(): \Generator
    {
        yield "saveIntegerSetting" => [
            'repositoryMethod' => 'saveIntegerSetting',
            'value' => 1234
        ];
        yield "saveFloatSetting" => [
            'repositoryMethod' => 'saveFloatSetting',
            'value' => 1_23
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
