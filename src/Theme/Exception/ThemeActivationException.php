<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

final class ThemeActivationException extends NotFound
{
    private const THEME_NOT_ACTIVATED = "An error occurred while activating the theme.";

    public function __construct(string $message = self::THEME_NOT_ACTIVATED)
    {
        parent::__construct($message);
    }
}
