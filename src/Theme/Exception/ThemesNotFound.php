<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

final class ThemesNotFound extends NotFound
{
    public function __construct()
    {
        parent::__construct(('No themes were found.'));
    }
}
