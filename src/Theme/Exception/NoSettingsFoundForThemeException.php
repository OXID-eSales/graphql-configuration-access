<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\NoSettingsFoundException;

class NoSettingsFoundForThemeException extends NoSettingsFoundException
{
    public function __construct(string $themeId)
    {
        $message = sprintf('No settings found for theme: %s', $themeId);

        parent::__construct($message);
    }
}
