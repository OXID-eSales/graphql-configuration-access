<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFiltersInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleFilterService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleFilterService
 */
class ModuleFilterServiceTest extends TestCase
{
    public function testFilterModules(): void
    {
        $title = uniqid();
        $id = uniqid();
        $version = uniqid();
        $description = uniqid();
        $lang = uniqid();
        $thumbnail = uniqid();
        $author = uniqid();
        $url = uniqid();
        $email = uniqid();

        $module1 = new ModuleDataType(
            id: $id,
            version: $version,
            title: 'Test',
            description: $description,
            thumbnail: $thumbnail,
            author: $author,
            url: $url,
            email: $email,
            active: true
        );

        $module2 = new ModuleDataType(
            id: $id,
            version: $version,
            title: $title,
            description: $description,
            thumbnail: $thumbnail,
            author: $author,
            url: $url,
            email: $email,
            active: false
        );

        $modulesList = [$module1,$module2];

        $moduleFiltersMock = $this->createMock(ModuleFiltersInterface::class);
        $moduleFiltersMock->method('filterModuleByTitle')
            ->willReturnCallback(function (ModuleDataType $module) {
                return str_contains($module->getTitle(), 'Test');
            });
        $moduleFiltersMock->method('filterModuleByStatus')
            ->willReturnCallback(function (ModuleDataType $module) {
                return $module->isActive();
            });

        $moduleFilterService = new ModuleFilterService();
        $modulesAfterFilter = $moduleFilterService->filterModules($modulesList, $moduleFiltersMock);

        $this->assertSame([$module1], $modulesAfterFilter);
    }
}
