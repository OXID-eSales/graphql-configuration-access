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
    public const THEME_NOT_ACTIVATED = "An error occurred while activating the theme.";
    public const THEME_NOT_EXIST = "The specified theme doesn't exist.";

    public function __construct(string $message = null)
    {
        if (empty($message)) {
            $message = self::THEME_NOT_ACTIVATED;
        }
        parent::__construct($message);
    }
}
