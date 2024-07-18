<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Controller;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeListController;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeFilterList;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeListServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller\ThemeListController
 */
class ThemeListControllerTest extends TestCase
{
    public function testThemesList(): void
    {
        $theme1 = new ThemeDataType('Test Theme 1', 'theme1', '1.0', 'Description 1', true);

        $themeListServiceMock = $this->createMock(ThemeListServiceInterface::class);
        $themeListServiceMock->method('getThemeList')->willReturn([$theme1]);

        $filtersList = new ThemeFilterList(
            title: new StringFilter(contains: 'Test Theme 1'),
            active: new BoolFilter(equals: true)
        );

        $themeListController = new ThemeListController($themeListServiceMock);
        $resultedThemeList = $themeListController->themesList($filtersList);

        $this->assertInstanceOf(ThemeDataType::class, $resultedThemeList[0]);
        $this->assertEquals($resultedThemeList[0], $theme1);
    }
}
