<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure;

use OxidEsales\Eshop\Core\Theme;

class CoreThemeFactory implements CoreThemeFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(): Theme
    {
        return $this->createTheme();
    }

    protected function createTheme(): Theme
    {
        return oxNew(Theme::class);
    }
}
