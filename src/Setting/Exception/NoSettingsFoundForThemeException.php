<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception;

class NoSettingsFoundForThemeException extends NoSettingsFoundException
{
    public function __construct(string $themeId)
    {
        $message = sprintf('No settings found for theme: %s', $themeId);

        parent::__construct($message);
    }
}
