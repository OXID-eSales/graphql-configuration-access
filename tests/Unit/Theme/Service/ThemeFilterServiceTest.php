<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeFilterService
 */
class ThemeFilterServiceTest extends TestCase
{
    public function testFilterThemes(): void
    {
        $theme1 = new ThemeDataType(uniqid(), uniqid(), uniqid(), uniqid(), true);
        $theme2 = new ThemeDataType(uniqid(), uniqid(), uniqid(), uniqid(), false);
        $themesList = [$theme1,$theme2];

        $themeFiltersMock = $this->createMock(ThemeFiltersInterface::class);
        $themeFiltersMock->method('filterThemeByTitle')
            ->willReturnCallback(function (ThemeDataType $theme) {
                return str_contains($theme->getTitle(), 'Test');
            });
        $themeFiltersMock->method('filterThemeByStatus')
            ->willReturnCallback(function (ThemeDataType $theme) {
                return $theme->isActive();
            });

        $themeFilterService = new ThemeFilterService();
        $themeFilterService->filterThemes($themesList, $themeFiltersMock);
    }
}
