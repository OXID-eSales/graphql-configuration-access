<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterListInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterService
 */
class ThemeFilterServiceTest extends TestCase
{
    public function testFilterThemes(): void
    {
        $theme1 = new ThemeDataType('Test Theme 1', 'theme1', '1.0', 'Description 1', true);
        $theme2 = new ThemeDataType('Test Theme 2', 'theme2', '2.1', 'Description 2', false);
        $themesList = [$theme1,$theme2];

        $themeFilterListMock = $this->createMock(ThemeFilterListInterface::class);
        $themeFilterListMock->method('filterThemeByTitle')
            ->willReturnCallback(function (ThemeDataType $theme) {
                return str_contains($theme->getTitle(), 'Test');
            });
        $themeFilterListMock->method('filterThemeByStatus')
            ->willReturnCallback(function (ThemeDataType $theme) {
                return $theme->isActive();
            });

        $themeFilterService = new ThemeFilterService();
        $themeFilterService->filterThemes($themesList, $themeFilterListMock);
    }
}
