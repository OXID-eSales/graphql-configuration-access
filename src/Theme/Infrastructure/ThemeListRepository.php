<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\OxNewFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType\ThemeDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception\ThemeNotFound;

final class ThemeListRepository implements ThemeListRepositoryInterface
{
    public function __construct(
        private readonly OxNewFactoryInterface $oxNewFactory
    ) {
    }


    public function getThemes(?string $status, ?string $title): array
    {
        $themeService = $this->oxNewFactory->getModel(Theme::class);
        $themes = $themeService->getList();

        $themesArray = [];
        foreach ($themes as $theme) {
            $themesArray[] = new ThemeDataType(
                title: $theme->getInfo('title'),
                identifier: $theme->getInfo('id'),
                version: $theme->getInfo('version'),
                description: $theme->getInfo('description'),
                active: $theme->getInfo('active')
            );
        }
        if (empty($themesArray)) {
            throw new ThemeNotFound();
        }
        return $themesArray;
    }
}
