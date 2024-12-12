<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\Eshop\Core\Theme;

class ThemeDataTypeFactory implements ThemeDataTypeFactoryInterface
{
    public function createFromCoreTheme(
        Theme $theme
    ): ThemeDataType {
        return new ThemeDataType(
            id: $theme->getInfo('id'),
            title: $theme->getInfo('title'),
            version: $theme->getInfo('version'),
            description: $theme->getInfo('description'),
            active: $theme->getInfo('active'),
            parentTheme: $theme->getInfo('parentTheme'),
            parentVersions: $theme->getInfo('parentVersions'),
        );
    }
}
